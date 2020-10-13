<?php
class WhatsApp
{      
   public function sendMessageFree($text, $target)
   {
        __curl(
            'https://conversations.messagebird.com/v1/send',
            [
                'to' => '+49xxxxxxxxx',
                'from' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                'type' => 'text',
                'content' => [ 'text' => 'Das funktioniert!' ],
                'reportUrl' => 'https://example.com/reports'
            ],
            'POST',
            ['Authorization' => 'AccessKey xxxxxxxxxxxxxxxxxxxxxxxxx'],
        );
   }
   
   public function sendMessageTemplate($tpl_name, $args)
   {
        __curl(
            'https://conversations.messagebird.com/v1/conversations/start',
            [
                'to' => '+49xxxxxxxxx',
                'from' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                'channelId' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                'type' => 'hsm',  
                'content'=> [
                    'hsm' => [
                        'namespace' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                        'templateName' => 'update3', 
                        'language' => [
                            'policy' => 'deterministic',
                            'code' => 'de'
                        ],
                        'params' => [ 
                            ['default' => 'David']
                        ]
                    ]
                ]
            ],
            'POST',
            ['Authorization' => 'AccessKey xxxxxxxxxxxxxxxxxxxxxxxxx'],
        );
   }

   public function getStatusOfMessage($id) {
        $data = __curl(
            'https://conversations.messagebird.com/v1/conversations',
            null,
            'GET',
            ['Authorization' => 'AccessKey xxxxxxxxxxxxxxxxxxxxxxxxx'],
        );
        foreach($data->result->items as $result__value) {
            if( $result__value['id'] !== $id ) {
                continue;
            }
            if($result__value->status === 'success' ) {
                return ['success' => false, 'message' => $result__value->error->description];
            }
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'message missing'];
   }
}