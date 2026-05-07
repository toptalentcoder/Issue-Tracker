<?php

namespace Database\Seeders;

use App\Models\Issue;
use App\Services\IssueAutomationService;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        $automation = app(IssueAutomationService::class);

        $issues = [
            [
                'title' => 'Customer cannot login',
                'description' => 'Customer sees an error message after resetting their password.',
                'priority' => 'high',
                'category' => 'technical',
                'status' => 'open',
            ],
            [
                'title' => 'Invoice was charged twice',
                'description' => 'Customer reports duplicate billing for the same monthly subscription.',
                'priority' => 'critical',
                'category' => 'billing',
                'status' => 'open',
            ],
            [
                'title' => 'Account permission issue',
                'description' => 'Operations user cannot access the order management dashboard.',
                'priority' => 'medium',
                'category' => 'account',
                'status' => 'in_progress',
            ],
        ];

        foreach ($issues as $issue) {
            Issue::create(array_merge(
                $issue,
                $automation->processIssue($issue)
            ));
        }
    }
}