<?php

namespace AuditStash\Test\Meta;

use AuditStash\Event\AuditCreateEvent;
use AuditStash\Event\AuditDeleteEvent;
use AuditStash\Event\AuditUpdateEvent;
use AuditStash\Meta\ApplicationMetadata;
use Cake\Event\EventManagertrait;
use Cake\TestSuite\TestCase;

class ApplicationMetadataTest extends TestCase
{

    use EventManagertrait;

    /**
     * Tests that metadata is added to the audit log objects
     *
     * @return void
     */
    public function testDataIsAdded()
    {
        $listener = new ApplicationMetadata('my_app', ['extra' => 'thing']);
        $this->eventManager()->attach($listener);
        $logs[] = new AuditDeleteEvent(1234, 1, 'articles');
        $event = $this->dispatchEvent('AuditStash.beforeLog', ['logs' => $logs]);

        $expected = [
            'app_name' => 'my_app',
            'extra' => 'thing',
        ];
        $this->assertEquals($expected, $logs[0]->getMetaInfo());
    }
}
