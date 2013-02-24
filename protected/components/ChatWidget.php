<?php

// \protected\components\ChatWidget.php

class ChatWidget extends CWidget {
    /** test
     */
    public $data;

    public function run()     {
        $this->render('chatWidget', array('data'=>$this->data));
        // $this->render('chatWidget');
    }
}

