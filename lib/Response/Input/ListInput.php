<?php

namespace Phpactor\Extension\Rpc\Response\Input;

class ListInput extends ChoiceInput
{
    private $allowMultipleResults = false;

    public function type(): string
    {
        return 'list';
    }

    public function setAllowMultipleResults(bool $allowMultipleResults): self
    {
        $this->allowMultipleResults = $allowMultipleResults;

        return $this;
    }

    public function parameters(): array
    {
        return array_merge(parent::parameters(), [
            'multi' => $this->allowMultipleResults,
        ]);
    }
}
