<?php  class Biztech_Notification_Block_Notificationdesign extends Mage_Core_Block_Template
    {
    
        public function useDefaultStyles()
        {
            return Mage::getStoreConfig('notification/notification_general/default_style');
        }

        public function getPosition() {
            return $this->_getNotificationBlock()->getPosition();
        }

      
        public function getBodyMargin() {
            return Mage::getStoreConfig('notification/notification_general/body_margin');
        }

        public function showNotifications()
        {
            return $this->_getNotificationBlock()->showNotifications();
        }

        protected function _getNotificationBlock() {
            return $this->getLayout()->getBlock('notification');
        }
    }
