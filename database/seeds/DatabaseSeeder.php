<?php

use App\Models\Owner;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Review;
use App\Models\Holiday;
use App\Models\MstUser;
use App\Models\UseTerm;
use App\Models\Contract;
use App\Models\Favorite;
use App\Models\MstAdmin;
use App\Models\OwnerBank;
use App\Models\OwnerPass;
use App\Models\ParkingLot;
use App\Models\Prefecture;
use App\Models\AdminNotice;
use App\Models\OwnerNotice;
use App\Models\ParkingMenu;
use App\Models\ParkingSpace;
use App\Models\UseSituation;
use App\Models\ParkingMenuTime;
use Illuminate\Database\Seeder;
use App\Models\ContractTemplate;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $prefectures = [
            '北海道', '青森県', '岩手県', '秋田県', '山形県', '宮城県', '福島県', '栃木県', '群馬県',
            '茨城県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '長野県',
            '岐阜県', '山梨県', '静岡県', '愛知県', '滋賀県', '三重県', '和歌山県', '奈良県', '京都府', '大阪府',
            '兵庫県', '岡山県', '広島県', '鳥取県', '島根県', '山口県', '香川県', '徳島県', '愛媛県', '高知県',
            '福岡県', '佐賀県', '長崎県', '大分県', '熊本県', '宮崎県', '鹿児島県', '沖縄県'
        ];

        $holidayDates = [
            ['2020/01/01', '元旦'], ['2020/01/13', '成人の日'], ['2020/02/11', '建国記念日'], ['2020/02/23', '天皇誕生日'], ['2020/02/24', '天皇誕生日'], ['2020/03/20', '春分の日'],
            ['2020/04/29', '昭和の日'], ['2020/05/03', '憲法記念日'], ['2020/05/04', '緑の日'], ['2020/05/05', 'こどもの日'], ['2020/05/06', '憲法記念日'], ['2020/07/23', 'マリンデー'],
            ['2020/07/24', '健康スポーツデー'], ['2020/08/10', '山の日'], ['2020/08/13', 'お盆'], ['2020/08/14', 'お盆'], ['2020/08/15', 'お盆'], ['2020/09/21', '敬老の日'],
            ['2020/09/22', '秋分の日'], ['2020/11/03', '文化の日'], ['2020/11/23', '労働感謝祭'],
        ];
        factory(MstAdmin::class, 1)->create();
        factory(MstUser::class, 25)->create();
        factory(Contract::class, 10)->create();
        factory(ContractTemplate::class, 10)->create();
        factory(UseTerm::class, 10)->create();
        factory(AdminNotice::class, 10)->create();
        factory(Owner::class, 3)->create()->each(function ($owner) {
            $owner->menuMaster()->create(
                [
                    'owner_cd' => $owner->owner_cd,
                    'parking_cd' => null,
                    'month_flg' => ParkingMenu::MONTH_FLG_DISABLE,
                    'day_flg' => ParkingMenu::DAY_FLG_DISABLE,
                    'period_flg' => ParkingMenu::PERIOD_FLG_DISABLE,
                    'time_flg' => ParkingMenu::TIME_FLG_DISABLE
                ]
            );
            $owner->ownerPass()->save(factory(OwnerPass::class)->make());
            $owner->ownerBank()->save(factory(OwnerBank::class)->make());
            $owner->parkingLot()->saveMany(factory(ParkingLot::class, 40)->create()->each(function ($parkingLot) use ($owner) {
                $parkingLot->parkingSpaces()->saveMany(factory(ParkingSpace::class, rand(10, 30))->make());
                $parkingLot->parkingMenu()->saveMany(factory(ParkingMenu::class, 1)
                    ->create([
                        'parking_cd' => $parkingLot->parking_cd,
                        'owner_cd' => $owner->owner_cd
                    ])
                    ->each(function ($parkingMenu) {
                        $parkingMenu->parkingMenuTime()->saveMany(factory(ParkingMenuTime::class, 5)->make());
                    }));
                $parkingLot->useSituations()->saveMany(factory(UseSituation::class, 10)->create([
                    'parking_cd' => $parkingLot->parking_cd,
                    'owner_cd' => $owner->owner_cd
                ]));
                $parkingLot->reviews()->saveMany(factory(Review::class, rand(20, 50))->create(['parking_cd' => $parkingLot->parking_cd]));
                $parkingLot->favorites()->saveMany(factory(Favorite::class, 1)->create(['parking_cd' => $parkingLot->parking_cd]));

                $parkingLot->ownerNotices()->saveMany(factory(OwnerNotice::class, 5)
                    ->create([
                        'parking_cd' => $parkingLot->parking_cd,
                        'member_cd' => $owner->owner_cd
                    ]));
            }));
        });
        factory(Owner::class, 20)->create()->each(function ($owner) {
            $owner->menuMaster()->create(
                [
                    'owner_cd' => $owner->owner_cd,
                    'parking_cd' => null
                ]
            );
        });
        foreach ($prefectures as $prefecture) {
            factory(Prefecture::class)->create(['prefectures_name' => $prefecture]);
        }

        foreach ($holidayDates as $holidayDate) {
            factory(Holiday::class)->create(['date' => $holidayDate[0], 'comment' => $holidayDate[1]]);
        }

        factory(QuestionCategory::class, 12)->create()->each(function ($questionCategory) {
            $questionCategory->questions()->saveMany(factory(Question::class, 4)->create(
                [
                    'category_id' => $questionCategory->category_id
                ]
            ));
        });
    }
}
