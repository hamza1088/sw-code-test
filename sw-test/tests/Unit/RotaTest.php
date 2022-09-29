<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rota\Rota;
use Illuminate\Support\Collection;

class RotaTest extends TestCase
{
    private Rota $rota;
    private Collection $rotaInfo;
    protected function setUp(): void
    {
        parent::setUp();

        $this->rota = new Rota();
        $this->rotaInfo = $this->rota->createRota();
    }

   
    public function test_it_get_rota_shifts()
    {
        $this->rotaInfo->has('shifts') ? $this->assertTrue(true)
            : $this->assertTrue(false);

        !$this->rotaInfo->get('shifts')->isEmpty() ? $this->assertTrue(true)
        : $this->assertTrue(false);
    }

    public function test_it_get_rota_shift_breaks()
    {
        $this->rotaInfo->has('breaks') ? $this->assertTrue(true)
            : $this->assertTrue(false);

        count($this->rotaInfo->get('breaks')) > 0 ? $this->assertTrue(true)
        : $this->assertTrue(false);
    }
}
