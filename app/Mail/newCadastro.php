<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Veterinary_dates_booked;
use App\Veterinary_client;
use App\Veterinary_patient;
use App\System_company;

class newCadastro extends Mailable
{
    use Queueable, SerializesModels;

    public $agendamento;
    public $client;
    public $patient;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Veterinary_dates_booked $agendamento, Veterinary_client $client, Veterinary_patient $patient, System_company $company)
    {
        $this->agendamento = $agendamento;
        $this->client = $client;
        $this->patient = $patient;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Agendamento de Consulta');
        //$this->from($this->company->email, $this->company->name);
        $this->to($this->client->email, $this->client->name);
        return $this->markdown('mail.newAgenda');
    }
}
