<?php

namespace PhpAmqpLib\Tests\Functional;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;

class TimeoutTest extends TestCase
{
    /**
     * Make a first
     */
    public function testWriteSleepLessThanTimeout()
    {
        $connection = new AMQPStreamConnection(
            HOST,
            PORT,
            USER,
            PASS,
            VHOST,
            false,
            'AMQPLAIN',
            null,
            'en_US',
            2.0, //connection timeout
            2.0, //write timeout
            null,
            false, //keepalive
            1 //hearbeat
        );

        $ch = $connection->channel();

        $ch->basic_publish(
            new AMQPMessage(),
            'foo',
            'bar',
            true
        );

        sleep(1);

        $ch->basic_publish(
            new AMQPMessage(),
            'foo',
            'bar',
            true
        );
    }

    /**
     * Make a first
     */
    public function testWriteSleepMoreThanTimeout()
    {
        $connection = new AMQPStreamConnection(
            HOST,
            PORT,
            USER,
            PASS,
            VHOST,
            false,
            'AMQPLAIN',
            null,
            'en_US',
            2.0, //connection timeout
            2.0, //write timeout
            null,
            false, //keepalive
            1 //hearbeat
        );

        $ch = $connection->channel();

        $ch->basic_publish(
            new AMQPMessage(),
            'foo',
            'bar',
            true
        );

        sleep(3);

        $ch->basic_publish(
            new AMQPMessage(),
            'foo',
            'bar',
            true
        );
    }

    /**
     * Make a first
     */
    public function testReadSleepLessThanTimeout()
    {
        $connection = new AMQPStreamConnection(
            HOST,
            PORT,
            USER,
            PASS,
            VHOST,
            false,
            'AMQPLAIN',
            null,
            'en_US',
            2.0, //connection timeout
            2.0, //write timeout
            null,
            false, //keepalive
            1 //hearbeat
        );

        $ch = $connection->channel();

        $ch->queue_declare('foo', false, false, true);

        $ch->basic_consume('foo');

        sleep(1);

        $ch->basic_consume('foo');
    }

    /**
     * Make a first
     */
    public function testReadSleepMoreThanTimeout()
    {
        $connection = new AMQPStreamConnection(
            HOST,
            PORT,
            USER,
            PASS,
            VHOST,
            false,
            'AMQPLAIN',
            null,
            'en_US',
            2.0, //connection timeout
            2.0, //write timeout
            null,
            false, //keepalive
            1 //hearbeat
        );

        $ch = $connection->channel();

        $ch->queue_declare('foo', false, false, true);

        $ch->basic_consume('foo');

        sleep(3);

        $ch->basic_consume('foo');
    }
}