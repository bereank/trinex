<?php

namespace App\Actions\ApprovalProccessActions;

use App\Models\ApprovalProcess\ApprovalStage;

class CheckApprovalStageRuleAction
{
    public function __construct(protected ApprovalStage $approvalStage, protected float $docTotal)
    {
        $this->approvalStage = $approvalStage;
        $this->docTotal = $docTotal;
    }

    public function handle(): bool
    {

        if ($this->approvalStage->stagerule->ruleCheckType == 1) {

            if ($this->docTotal > $this->approvalStage->stagerule->lowerValue && $this->docTotal < $this->approvalStage->stagerule->higherValue) {

                return true;
            }

            if ($this->docTotal > $this->approvalStage->stagerule->lowerValue) {

                return true;
            }

            return false;

        }

        if ($this->approvalStage->stagerule->ruleCheckType == 2 && $this->docTotal >= $this->approvalStage->stagerule->lowerValue) {

            return true;
        }

        if ($this->approvalStage->stagerule->ruleCheckType == 3 && $this->docTotal >= $this->approvalStage->stagerule->lowerValue) {

            return true;
        }

        return false;
    }
}
