<?php

namespace App\Application\Club\GetClub;

use App\Application\Shared\AbstractCommand;
use Webmozart\Assert\Assert;

class Query extends AbstractCommand
{

    /**
     * @var array $data
     */
    protected $data;

    public function __construct(array $data) 
    {
        $this->data = $data;
    }

    public function getClubId(): int
    {
        return $this->data['clubId'];
    }
    
    public function assertMandatoryAttributes()
    {
        // In this method we will check the typing of the variables and if the need to be mandatory or not
        Assert::propertyExists($this->data['clubId'], 'clubId');
        Assert::integer($this->data['clubId']);
    }

}
