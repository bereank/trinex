<?php

namespace App\Actions\ValidationActions;

class ItemDescriptionAction
{
    public function __construct(protected string $itemDescription)
    {
        $this->itemDescription = $itemDescription;
    }

    public function handle()
    {

        if (strlen($this->itemDescription) > 100) {
            throw new \ErrorException('Description too long');
        }
    }
}
