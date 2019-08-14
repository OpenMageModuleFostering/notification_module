<?php
    class Biztech_Notification_Block_Notification extends Mage_Core_Block_Template
    {
        public function showNotifications()
        {
            
            if($this->getPosition() == 'popup')
            { 
                return Mage::getStoreConfig('notification/notification_general/enabled') && 
                $this->NotificationContent() &&
                (!$this->isNotificationCleared() || $this->closeNotification()) &&
                $this->afterStartDate() &&
                $this->beforeEndDate();
            }
            
            if($this->getPosition() == 'bottom' || $this->getPosition() == 'top')
            {
                return Mage::getStoreConfig('notification/notification_general/enabled') && 
                $this->NotificationContent() &&
                (!$this->isNotificationCleared() || !$this->closeNotification()) &&
                $this->afterStartDate() &&
                $this->beforeEndDate();
            }
            
            
            
        }

        public function getNotificationText()
        {
            $content = Mage::getStoreConfig('notification/notification_general/content');

            $helper = Mage::helper('cms');
            if($helper) {
                $processor = $helper->getBlockTemplateProcessor();
                if($processor) {
                    $content = $processor->filter($content); 
                }
            }

            return $content;
        }

     
        protected function NotificationContent() {
            $content = $this->getNotificationText();
            return !empty($content);
        }

     
        public function closeNotification() {
            return Mage::getStoreConfig('notification/notification_general/close_notification');
        }

    
        public function getNotificationClearCookieName() {
            return 'clear_notification'.preg_replace("/\W/", '', null);
        }

        /**
        * Returns true if the currently identified notification bar has been cleared
        * by the client.
        * 
        * @return boolean
        */
        public function isNotificationCleared() {
            return Mage::getSingleton('core/cookie')->get($this->getNotificationClearCookieName());
        }
        
        public function getPosition() {
            return Mage::getStoreConfig('notification/notification_general/position');
        }

        /**
        * @return boolean true if no start date is defined, or the current
        *         date is after the start date.
        */
        protected function afterStartDate() {
            list($year,$month,$day) = explode(',',Mage::getStoreConfig('notification/notification_general/start_date'));
            $str = null;
            if($year) {
                $str .= $year;
                if($month) {
                    $str .= "-".$month;
                    if($day) $str .= "-".$day;
                }

                return time() >= strtotime($str);  
            }
            return true;  
        }

        /**
        * @return boolean true if either no end date is defined, or the current
        *         date is after the start date, false otherwise.
        */
        protected function beforeEndDate() {
            list($year,$month,$day) = explode(',',Mage::getStoreConfig('notification/notification_general/end_date'));
            $str = null;
            if($year) {
                $str .= $year;
                if($month) {
                    $str .= "-".$month;
                    if($day) $str .= "-".$day;
                }

                return time() < strtotime($str);  
            }
            return true;  
        }

}