<?php

namespace Modules\Owner\Repositories\Auth;

use App\Models\Owner;
use App\Models\MstUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Modules\Owner\Emails\SendMailRegister;
use Modules\Owner\Repositories\RepositoryAbstract;

class AuthRepository extends RepositoryAbstract implements AuthRepositoryInterface
{
    protected $ownerModel;
    protected $mstUserModel;

    public function __construct(Owner $owner, MstUser $mstUser)
    {
        $this->ownerModel = $owner;
        $this->mstUserModel = $mstUser;
    }

    public function store($dataRequest)
    {

        if (isset($dataRequest['owner_cd'])) {
            $member = $this->ownerModel->create($dataRequest);
            $memberCd = $member->owner_cd ?? '';
            $member = config('owner.role_owner');
        } else {
            $member = $this->mstUserModel->create($dataRequest);
            $memberCd = $member->user_cd ?? '';
            $member = config('owner.role_user');
        }

        $mailConfig = [
            'code' => $dataRequest['certification_cd'],
            'url' => route('member.get.set.password', [
                'member_cd' => $memberCd,
                'member' => $member
            ]),
        ];

        $this->sendMail($mailConfig, $dataRequest['mail_add']);

        return [
            'member_cd' => $memberCd,
            'url_certification_or_exception' => route(
                'member.get.set.password',
                [
                    'member_cd' => $memberCd,
                    'member' => $member
                ]
            )
        ];
    }

    private function sendMail($mailConfig, $email)
    {
        Mail::to($email)->send(new SendMailRegister($mailConfig));
    }
}
