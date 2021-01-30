<?php

namespace Petrelli\LiveStatics\Tests\Extras\Mocks;

use Petrelli\LiveStatics\Tests\Extras\Interfaces\VideoInterface;
use Petrelli\LiveStatics\BaseMock;
use Illuminate\Support\Str;


class VideoMock extends BaseMock implements VideoInterface
{


	public static $baseInterface = VideoInterface::class;

    protected $primaryKey = 'id';


	// Mostly used to ignore eloquent scopes
	protected $returnSelfMethods = [
        'published'
    ];


	public static function define(&$mock)
	{

		// Attributes   
		$mock->id          = 100;
		$mock->title       = 'Video Title';
		$mock->slug        = \Str::slug($mock->title);
        $mock->url         = 'http://youtube.com';

        // Dynamic attributes
        $mock->description = app('faker')->dynamic('Description')->text(1000);

	}


    public function getUrlMutatorAttribute()
    {

        return 'http://youtube.com/mutator';

    }


}
