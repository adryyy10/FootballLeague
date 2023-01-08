<?php

namespace App\Application\Club\GetClubBySlug;

use App\Application\Shared\AbstractCommand;
use stdClass;
use Webmozart\Assert\Assert;

class Query extends AbstractCommand
{

    /**
     * @var stdClass $data
     */
    public $data;

    public function __construct(stdClass $data) 
    {
        parent::__construct($data);
        $this->data = $data;
    }

    public function getSlug(): string
    {
        return $this->data->slug;
    }
    
    /**
     * This method checks the type of the variables and if they are mandatory or not
     */
    protected function assertMandatoryAttributes()
    {
        Assert::propertyExists($this->data, 'slug');
        Assert::string($this->data->slug);
    }

}
