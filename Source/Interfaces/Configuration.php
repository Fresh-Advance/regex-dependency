<?php

namespace FreshAdvance\Dependency\Interfaces;

interface Configuration
{
    /**
     * @return array<string,mixed>
     */
    public function fetch(): array;
}
