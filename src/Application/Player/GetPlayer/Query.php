<?php

namespace App\Application\Player\GetPlayer;

use App\Application\Shared\AbstractCommand;
use stdClass;
use Webmozart\Assert\Assert;

class Query extends AbstractCommand
{
 /**
     * @var stdClass $data
     */
    protected $data;

    public function __construct(stdClass $data) 
    {
        parent::__construct($data);
        $this->data = $data;
    }

    public function getId(): int
    {
        return $this->data->id;
    }
    
    /**
     * This method checks the type of the variables and if they are mandatory or not
     */
    public function assertMandatoryAttributes()
    {
        Assert::propertyExists($this->data, 'id');
        Assert::integer($this->data->id);
    }
}
