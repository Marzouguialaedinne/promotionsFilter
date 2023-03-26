<?php
namespace App\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceTest extends WebTestCase
{
	public ContainerInterface $container;

	protected function setUp(): void
	{
		$this->container = static::createClient()->getContainer();
	}
}