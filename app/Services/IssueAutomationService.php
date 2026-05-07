<?php

namespace App\Services;

class IssueAutomationService
{
    public function processIssue(array $data): array
    {
        $description = strtolower($data['description']);

        $summary = $this->generateSummary($data['description']);
        $suggestedAction = $this->generateSuggestedAction(
            $data['category'],
            $description
        );

        $escalationRequired = $this->shouldEscalate(
            $data['priority'],
            $data['status'] ?? 'open'
        );

        return [
            'summary' => $summary,
            'suggested_action' => $suggestedAction,
            'escalation_required' => $escalationRequired,
        ];
    }

    private function generateSummary(string $description): string
    {
        return substr($description, 0, 120);
    }

    private function generateSuggestedAction(
        string $category,
        string $description
    ): string {
        $category = strtolower($category);

        if ($category === 'billing') {
            return 'Review payment records and verify invoice status.';
        }

        if ($category === 'technical') {
            return 'Collect logs and reproduce the issue.';
        }

        if ($category === 'account') {
            return 'Verify account permissions and authentication flow.';
        }

        if (str_contains($description, 'error')) {
            return 'Check application logs for related errors.';
        }

        return 'Assign issue to support team for investigation.';
    }

    private function shouldEscalate(
        string $priority,
        string $status
    ): bool {
        return in_array($priority, ['high', 'critical'])
            && $status !== 'resolved';
    }
}