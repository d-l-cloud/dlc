<?php

namespace App\Console\Commands;

use App\Mail\formMailSend;
use App\Models\Site\SiteForm;
use App\Models\Site\SiteSettings;
use App\Notifications\NotifyFormEmailUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class sendFormEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dlcloud:sendFormEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отправка сообщений с сайта';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $getSendMailList = SiteForm::where('sendMail','=',0)->get();
        foreach ($getSendMailList as $MailListItem) {
            $findesiteSettings = SiteSettings::where('id', '=', 1)->first();
            if ($findesiteSettings){
                $myEmail = $findesiteSettings->emailNotifications;
            }else {
                $myEmail = 'robopost@d-l.cloud';
            }

            $details = [
                'title' => 'Запрос с сайта',
                'questionType' => $MailListItem->questionType,
                'productName' => $MailListItem->productName,
                'name' => $MailListItem->name,
                'email' => $MailListItem->email,
                'phone' => $MailListItem->phone,
                'text' => $MailListItem->text,
            ];
            $subject = 'Запрос с сайта';
            Mail::to($myEmail)->send(new formMailSend($details,$subject));
            $MailListItem->sendMail = 1;
            $MailListItem->save();
        }
    }
}
