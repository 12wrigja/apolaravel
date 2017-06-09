<?php

namespace APOSite\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContractSigned extends Mailable
{
    use Queueable, SerializesModels;

    private $userId, $userFullName, $contractName, $semesterText, $committees, $reason;

    /**
     * Create a new Contract Signed mail
     * @param $userId
     * @param $userFullName
     * @param $contractName
     * @param $semesterText
     * @param $committees
     * @param $reason
     *
     * @return void
     */
    public function __construct($userId, $userFullName, $contractName, $semesterText, $committees, $reason)
    {
        $this->userId = $userId;
        $this->userFullName = $userFullName;
        $this->contractName = $contractName;
        $this->semesterText = $semesterText;
        $this->committees = $committees;
        $this->reason = $reason;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contract.contract_signed')->with([
            'userId' => $this->userId,
            'userFullName' => $this->userFullName,
            'contractName' => $this->contractName,
            'semesterText' => $this->semesterText,
            'committees' => $this->committees,
            'reason' => $this->reason,
        ])->subject('Contract Signed for ' . $this->semesterText);
    }
}
