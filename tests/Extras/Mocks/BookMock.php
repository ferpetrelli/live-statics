<?php

namespace Petrelli\LiveStatics\Tests\Extras\Mocks;

use Petrelli\LiveStatics\Tests\Extras\Interfaces\BookInterface;
use Petrelli\LiveStatics\BaseMock;
use Illuminate\Support\Str;


class BookMock extends BaseMock implements BookInterface
{


	public static $baseInterface = BookInterface::class;

	protected $primaryKey = 'slug';

	// Mostly used to ignore eloquent scopes
	protected $returnSelfMethods = [
        'published'
    ];


	public static function define(&$mock)
	{

		// Attributes
		$mock->id          = 100;
		$mock->title       = 'Mocked Book';
		$mock->slug        = \Str::slug($mock->title);

        // Dynamic attributes
        $mock->description = app('faker')->dynamic('Description')->text(1000);

	}


}
