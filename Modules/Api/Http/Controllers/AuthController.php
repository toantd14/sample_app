<?php

namespace Modules\Api\Http\Controllers;

use JWTAuth;
use Facebook\Facebook;
use App\Models\MstUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Api\Traits\CurlTraits;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Modules\Api\Traits\ResponseServerErrorTrait;
use Modules\Api\Http\Requests\Auth\LineLoginRequest;
use Modules\Api\Http\Requests\Auth\EmailLoginRequest;
use Modules\Api\Http\Requests\Auth\GoogleLoginRequest;
use Modules\Api\Http\Requests\Auth\RefreshTokenRequest;
use Modules\Api\Traits\ResponseTokenExpiredOrIncorrect;
use Modules\Api\Http\Requests\Auth\FacebookLoginRequest;
use Modules\Api\Repositories\MstUser\MstUserRepositoryInterface;
use Modules\Api\Repositories\LoginToken\LoginTokenRepositoryInterface;

class AuthController extends Controller
{
    // Todo detached repository auth

    use CurlTraits;
    use ResponseTokenExpiredOrIncorrect;
    use ResponseServerErrorTrait;

    protected $loginTokenRepository;
    protected $mstUserRepository;

    public function __construct(
        LoginTokenRepositoryInterface $loginTokenRepository,
        MstUserRepositoryInterface $mstUserRepository
    ) {
        $this->loginTokenRepository = $loginTokenRepository;
        $this->mstUserRepository = $mstUserRepository;
    }

    public function loginEmail(EmailLoginRequest $request)
    {
        $loginToken = $this->loginTokenRepository->getByEmailMstUser($request['email']);
        if ($loginToken) {
            $tokenTimeIsExpired = Carbon::now()->format(config('constants.API.DATE_TIME_FORMAT')) >
                Carbon::parse($loginToken->expired_token_time)->format(config('constants.API.DATE_TIME_FORMAT'));

            if ($tokenTimeIsExpired) {
                $this->handleResponseTokenExpiredOrIncorrect();
            }
        }

        $credentials = [
            'mail_add' => $request['email'],
            'password' => $request['password'],
            'certification_result' => MstUser::CERTIFICATION_ACTIVE,
        ];

        if ($token = Auth::guard('api')->attempt($credentials)) {
            $loginToken = $this->createOrUpdateLoginTokens();

            return response()->json(
                [
                    'accessToken' => $token,
                    'refreshToken' => $loginToken->refresh_token,
                    'expiredTime' => $this->getExpiredTimeTokenJwt()
                ],
                Response::HTTP_OK
            );
        }

        return response()->json([
            "errors" => [
                "message" => [__('message.response.invalid_email_or_password')],
            ]
        ], Response::HTTP_BAD_REQUEST);
    }

    public function loginFacebook(FacebookLoginRequest $request)
    {
        $url = config('constants.URL_GET_INFOR_USER.FACEBOOK') . $request->accessToken;
        $userFacebook = $this->getDataCurl($url);
        $userFacebook = json_decode($userFacebook);

        if (isset($userFacebook->error)) {
            $this->handleResponseTokenExpiredOrIncorrect();
        }

        try {
            $user = $this->mstUserRepository->findOrCreateUser($userFacebook, MstUser::FACEBOOK);

            return $this->getLoginToken($user);
        } catch (QueryException $e) {
            return $this->handleResponseServerError();
        }
    }

    public function loginLine(LineLoginRequest $request)
    {
        $url = config('constants.URL_GET_INFOR_USER.LINE');
        $dataHeader =
            [
                'Authorization' => config('constants.URL_GET_INFOR_USER.TOKEN_TYPE_BEARER')
                    . ' ' . $request->accessToken
            ];

        $userLine = $this->getDataCurl($url, $dataHeader);
        $userLine = json_decode($userLine);

        if (!isset($userLine->userId)) {
            $this->handleResponseTokenExpiredOrIncorrect();
        }

        try {
            $user = $this->mstUserRepository->findOrCreateUser($userLine, MstUser::LINE);

            return $this->getLoginToken($user);
        } catch (QueryException $e) {
            return $this->handleResponseServerError();
        }
    }

    public function loginGoogle(GoogleLoginRequest $request)
    {
        $url = config('constants.URL_GET_INFOR_USER.GOOGLE') . $request->idToken;
        $userGoogle = $this->getDataCurl($url);
        $userGoogle = json_decode($userGoogle);

        if (isset($userGoogle->error)) {
            $this->handleResponseTokenExpiredOrIncorrect();
        }

        try {
            $user = $this->mstUserRepository->findOrCreateUser($userGoogle, MstUser::GOOGLE);

            return $this->getLoginToken($user);
        } catch (QueryException $e) {
            return $this->handleResponseServerError();
        }
    }

    public function refresh(RefreshTokenRequest $request)
    {
        try {
            $loginToken = $this->loginTokenRepository->findByRefreshToken($request->refreshToken);

            if (!$loginToken) {
                $this->handleResponseTokenExpiredOrIncorrect();
            }

            $user = $this->mstUserRepository->get($loginToken->user_cd);

            return $this->getLoginToken($user);
        } catch (QueryException $e) {
            return $this->handleResponseServerError();
        }
    }

    public function getExpiredTimeTokenJwt()
    {
        $payload = Auth::guard('api')->payload();

        return Carbon::parse($payload->get('exp'))->format(config('constants.API.DATE_TIME_FORMAT'));
    }

    public function setExpiredRefreshTokenTime()
    {
        return Carbon::now()
            ->addHours(config('constants.TIME.EXPIRED_REFRESH_TOKEN_DAY'))
            ->format(config('constants.API.DATE_TIME_FORMAT'));
    }

    public function makeRefreshToken()
    {
        return Hash::make(Str::random(config('constants.LENGTH_STRING_TOKEN')));
    }

    public function createOrUpdateLoginTokens()
    {
        $expiredRefreshTokenTime = $this->setExpiredRefreshTokenTime();
        $dataUpdate = [
            'refresh_token' => $this->makeRefreshToken(),
            'expired_refresh_token_time' => $expiredRefreshTokenTime
        ];

        return $this->loginTokenRepository->updateOrCreate(
            [
                'user_cd' => Auth::guard('api')->user()->user_cd
            ],
            $dataUpdate
        );
    }

    public function getLoginToken($user)
    {
        $token = Auth::guard('api')->login($user);
        $loginToken = $this->createOrUpdateLoginTokens();

        return response()->json(
            [
                'accessToken' => $token,
                'refreshToken' => $loginToken->refresh_token,
                'expiredTime' => $this->getExpiredTimeTokenJwt()
            ],
            Response::HTTP_OK
        );
    }
}
