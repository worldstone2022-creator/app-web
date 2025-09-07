<?php

namespace Modules\Asset\Notifications;

use App\Notifications\BaseNotification;
use Modules\Asset\Entities\Asset;
use Modules\Asset\Entities\AssetHistory;

class AssetReturn extends BaseNotification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $asset;

    private $history;

    public function __construct(Asset $asset, AssetHistory $history)
    {
        $this->asset = $asset;
        $this->history = $history;
        $this->company = $this->asset->company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    //phpcs:ignore
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return parent::build()
            ->subject(__('asset::app.assetReturn'))
            ->greeting(__('email.hello').' '.$notifiable->name.'!')
            ->line(__('asset::app.assetReturnMessageForMail'))
            ->line(__('asset::app.assetName').': '.$this->asset->name)
            ->line(__('asset::app.dateGiven').': '.$this->history->date_given->format('d F Y H:i A'))
            //phpcs:ignore
            ->line(__('asset::app.returnDate').': '.(! is_null($this->history->return_date) ? $this->history->return_date->format('d F Y H:i A') : '-'))
            //phpcs:ignore
            ->line(__('asset::app.dateOfReturn').': '.(! is_null($this->history->date_of_return) ? $this->history->date_of_return->format('d F Y H:i A') : '-'))
            ->line(__('asset::app.lendBy').': '.$this->history->lender->name)
            ->line(__('asset::app.returnedBy').': '.$this->history->returner->name)
            ->line(__('asset::app.notes').': '.(! is_null($this->history->notes) ? $this->history->notes : '-'))
            ->line(__('email.thankyouNote'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    //phpcs:ignore
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
