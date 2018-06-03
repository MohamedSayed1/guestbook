<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 5/31/2018
 * Time: 1:38 AM
 */

class messagesClass
{
    private $DB ;

    public function __construct(DBinterface $dbobject )
    {
        // connected DB
        $this->DB = $dbobject ;
        $this->DB->table ='message';
    }

    //add massage
        public function addMassage(allPramter $item)
        {
            // get data
            $data = [
              'title'       => $item->getTitle(),
              'message'     => $item->getMessage(),
              'name'        => $item->getName(),
              'email'       => $item->getEmail(),
              'phone'       => $item->getPhone(),
              'published'   => 0
            ];

            //insert

            return $this->DB->Insert($data);
        }

    //update massage

    public function update(allPramter $item)
    {
        // get data
        $data = [
            'title'       => $item->getTitle(),
            'message'     => $item->getMessage(),
            'published'   => $item->getPuplished()
        ];

        // update
        $id = $item->getMassageId();

       return $this->DB->Update($data,"WHERE `message_id` = $id ");
    }

    //get massages

    public function getMessages($where = ''){

        //query
        $q     = "SELECT * FROM `{$this->DB->table}`" . $where;
        $query =  $this->DB->Execute($q);
        //fetsh date
        $rows =$this->DB->GetRows();
        return $rows ;
    }

    //get message
    public function getMessage($id)
    {
        //get mess query
        $message = $this->getMessages("WHERE `message_id` = $id ");
        // [of data ] or []
        if($message > 0)
            return $message ;


        return [];
    }

    //approved
    public function approved()
    {
        //get mess query
        $message = $this->getMessages("WHERE `published` = 1 ");
        // [of data ] or []
        return $message;
    }

    //un published

    public function unpublished()
    {
        //get mess query
        $message = $this->getMessages("WHERE `published` = 0 ");
        // [of data ] or []
        return $message;
    }

    //search

    public function searchMessage($keywords)
    {
        $query = $this->getMessages("WHERE  `title` LIKE '%$keywords%' OR `message` LIKE '%$keywords%' ");
        return $query;
    }



}