<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Event\AfterDtoCreatedEvent;
use App\Service\ServiceException;
use App\Tests\ServiceTestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class DtoSubscriberTest extends ServiceTestCase
{
    /** @test */
    public function a_dto_is_validated_after_is_has_been_created(): void
    {
        $dto = new LowestPriceEnquiry();
        $dto->setQuantity(-5);

        $event = new AfterDtoCreatedEvent($dto);

        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->container->get('debug.event_dispatcher');

        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('ConstraintViolationList');

        $eventDispatcher->dispatch($event, $event::NAME);
    }
}