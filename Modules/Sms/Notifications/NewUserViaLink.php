<?php

namespace Modules\Sms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Modules\Sms\Entities\SmsNotificationSetting;
use Modules\Sms\Http\Traits\WhatsappMessageTrait;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewUserViaLink extends Notification implements ShouldQueue
{
    use Queueable, WhatsappMessageTrait;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $new_user;

    private $smsSetting;

    private $message;

    private $company;

    public function __construct($new_user, $user)
    {
        $this->new_user = $new_user;
        $this->company = $user->company;
        $this->smsSetting = SmsNotificationSetting::where('slug', 'user-join-via-invitation')->where('company_id', $this->company->id)->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($this->smsSetting && $this->smsSetting->send_sms != 'yes') {
            return [];
        }

        $this->message = __('email.newUserViaLink.subject')."\n".__('email.newUserViaLink.text')."\n".__('app.name').':- '.$this->new_user->name."\n".__('app.email').':- '.$this->new_user->email."\n".__('app.phone').':- '.$this->new_user->mobile;

        $via = [];

        if (! is_null($notifiable->mobile) && ! is_null($notifiable->country_phonecode)) {
            if (sms_setting()->status) {
                array_push($via, TwilioChannel::class);
            }

            if (sms_setting()->nexmo_status) {
                array_push($via, 'vonage');
            }

            if ($this->smsSetting->msg91_flow_id && sms_setting()->msg91_status) {
                array_push($via, 'msg91');
            }
        }

        if (sms_setting()->telegram_status && $notifiable->telegram_user_id) {
            array_push($via, 'telegram');
        }

        return $via;
    }

    public function toTwilio($notifiable)
    {
        $this->toWhatsapp(
            $this->smsSetting->slug,
            $notifiable,
            __($this->smsSetting->slug->translationString(), ['name' => $this->new_user->name, 'email' => $this->new_user->email, 'phone' => $this->new_user->mobile]),
            ['1' => $this->new_user->name, '2' => $this->new_user->email, '3' => $this->new_user->mobile]
        );

        if (sms_setting()->status) {
            return (new TwilioSmsMessage)
                ->content($this->message);
        }
    }

    //phpcs:ignore
    public function toVonage($notifiable)
    {
        if (sms_setting()->nexmo_status) {
            return (new VonageMessage)
                ->content($this->message)->unicode();
        }
    }

    //phpcs:ignore
    public function toMsg91($notifiable)
    {
        if ($this->smsSetting->msg91_flow_id && sms_setting()->msg91_status) {
            return (new \Craftsys\Notifications\Messages\Msg91SMS)
                ->flow($this->smsSetting->msg91_flow_id)
                ->variable('name', $this->new_user->name)
                ->variable('email', $this->new_user->email)
                ->variable('phone', $this->new_user->mobile);
        }
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            // Optional recipient user id.
            ->to($notifiable->telegram_user_id)
            // Markdown supported.
            ->content($this->message)
            ->button(__('email.newUserViaLink.action'), route('employees.show', $this->new_user->id));
    }
}
