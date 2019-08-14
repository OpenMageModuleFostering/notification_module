<?php
    /**
    * @category    Biztech
    * @package     Biztech_Notification
    */
    class Biztech_Notification_Block_Styles extends Mage_Core_Block_Template
    {
        const XML_PATH_NOTIFICATION_DEFAULT_STYLE = 'notification/notification_general/default_style';
        const XML_PATH_NOTIFICATION_FIXED_MARGIN  = 'notification/notification_general/fixed_margin';
        const XML_NOTIFICATION_BLOCK_NAME         = 'notification';

        /**
        * Return true if the default styling should be used
        *
        * @return boolean
        */
        public function useDefaultStyles()
        {
            return Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_DEFAULT_STYLE);
        }

        /**
        * Return true if the notification bar should be fixed in place at the top
        * 
        * @return boolean
        */
        public function isFixed() {
            return $this->_getNotificationBlock()->isFixed();
        }

        /**
        * Returns the top margin value to apply to the body element when the 
        * notification bar is fixed in place
        * 
        * @return string
        */
        public function getFixedMargin() {
            return Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_FIXED_MARGIN);
        }

        /**
        * Check if the notifications bar should be displayed
        *
        * @return boolean
        */
        public function showNotifications()
        {
            return $this->_getNotificationBlock()->showNotifications();
        }

        /**
        * Return the notification bar block object, which is used to query the
        * state of the notification bar configurations
        * 
        * @return Biztech_NotificationBar_Block_Html_Notifications
        */
        protected function _getNotificationBlock() {
            return $this->getLayout()->getBlock(self::XML_NOTIFICATION_BLOCK_NAME);
        }
    }
