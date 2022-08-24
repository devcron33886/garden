<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new \App\Setting();
        $setting->company_name = "Garden Of Eden Produce";
        $setting->phoneNumber1 = "0784929046";
        $setting->phoneNumber2 = "0780661813";
        $setting->whatsapp = "0728177613";
        $setting->email1 = "frankuwuzuyinema@yahoo.fr";
        $setting->email2 = "mtotocami@live.com";
        $setting->address = "J.Lynn's Kagugu , Rouge Hotel KG 414";
        $setting->logo = "";
  $setting->about = "About us";
        $setting->save();
    }
}
