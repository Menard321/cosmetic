<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SmsService;

class TestSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-sms {phone} {message=Hello! This is a test from Niffer Cosmetic professional system.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the NextSMS API integration';

    /**
     * Execute the console command.
     */
    public function handle(SmsService $smsService)
    {
        $phone = $this->argument('phone');
        $message = $this->argument('message');

        $this->info("Attempting to send SMS to: {$phone}");
        
        $result = $smsService->sendSms($phone, $message);

        if ($result['success']) {
            $this->success("SMS sent successfully!");
            $this->line(json_encode($result['data'], JSON_PRETTY_PRINT));
        } else {
            $this->error("Failed to send SMS:");
            $this->line($result['message']);
        }
    }
}
