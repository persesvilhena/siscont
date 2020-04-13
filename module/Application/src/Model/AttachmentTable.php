<?php

namespace Application\Model;

use Core\Model\AbstractCoreModelTable;

class AttachmentTable extends AbstractCoreModelTable
{
    public function findAll(array $params)
    {
        return $this->tableGateway->select($params);
    }

    public function saveAttachments(array $data, Ticket $ticket)
    {
        $attachments = $data['attachment'];
        unset($data['attachment']);

        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $tmp_name = explode('\\', $attachment['tmp_name']);

                $this->save([
                    'name' => $attachment['name'],
                    'file' => end($tmp_name),
                    'ticket' => $ticket->id
                ]);
            }
        }
    }

    public function deleteAttachments($ticketId)
    {
        $attachments = $this->findAll([
            'ticket' => $ticketId
        ]);

        foreach ($attachments as $attachment) {
            $dir = __DIR__.'/../../../../public/upload/';
            $this->delete($attachment->id);
            unlink($dir.$attachment->file);
        }
    }
}