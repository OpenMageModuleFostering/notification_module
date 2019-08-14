<?php
    class Biztech_Notification_Block_Notification extends Mage_Core_Block_Template
    {

        const XML_PATH_NOTIFICATION_DISPLAY       = 'notification/notification_general/display';
        const XML_PATH_NOTIFICATION_CONTENT       = 'notification/notification_general/content';
        const XML_PATH_NOTIFICATION_CLEAR_CONTROL = 'notification/notification_general/clearcontrol';
        const XML_PATH_NOTIFICATION_IDENTIFIER    = 'notification/notification_general/identifier';
        const XML_PATH_NOTIFICATION_FIXED         = 'notification/notification_general/fixed';
        const XML_PATH_NOTIFICATION_START_DATE    = 'notification/notification_general/start_date';
        const XML_PATH_NOTIFICATION_END_DATE      = 'notification/notification_general/end_date';

        /**
        * Check if the notifications bar should be displayed
        *
        * @return boolean
        */
        public function showNotifications()
        {
            // notification bar enabled
            // AND bar is either not cleared OR bar is not allowed to be cleared
            // AND after start date
            // AND before end date
            return Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_DISPLAY) && 
            $this->_hasNotificationContent() &&
            (!$this->isNotificationCleared() || !$this->allowClearControl()) &&
            $this->_afterStartDate() &&
            $this->_beforeEndDate();
        }

        /**
        * Fetches the notification bar content
        * 
        * @return string
        */
        public function getNotificationText()
        {
            $content = Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_CONTENT);

            $helper = Mage::helper('cms');
            if($helper) {
                $processor = $helper->getBlockTemplateProcessor();
                if($processor) {
                    $content = $processor->filter($content); 
                }
            }

            return $content;
        }

        /**
        * Returns true if there is notification content to display
        * 
        * @return boolean
        */
        protected function _hasNotificationContent() {
            $content = $this->getNotificationText();
            return !empty($content);
        }

        /**
        * Returns true if the notification bar should be able to be closed/cleared
        * 
        * @return boolean
        */
        public function allowClearControl() {
            return Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_CLEAR_CONTROL);
        }

        /**
        * Returns the notification bar cookie name, which includes the current
        * notification bar identifier, if any.
        * 
        * @return string
        */
        public function getNotificationClearCookieName() {
            return 'clear_notification'.preg_replace("/\W/", '', Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_IDENTIFIER));
        }

        /**
        * Returns true if the currently identified notification bar has been cleared
        * by the client, false otherwise
        * 
        * @return boolean
        */
        public function isNotificationCleared() {
            return Mage::getSingleton('core/cookie')->get($this->getNotificationClearCookieName());
        }

        /**
        * Return true if the notification bar should be fixed in place at the top
        * 
        * @return boolean
        */
        public function isFixed() {
            return Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_FIXED);
        }

        /**
        * Returns true if the notification bar should be displayed based on the
        * start_date.
        * 
        * @return boolean true if either no start date is defined, or the current
        *         date is after the start date, false otherwise.
        */
        protected function _afterStartDate() {
            list($year,$month,$day) = explode(',',Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_START_DATE));
            $str = null;
            if($year) {
                $str .= $year;
                if($month) {
                    $str .= "-".$month;
                    if($day) $str .= "-".$day;
                }

                return time() >= strtotime($str);  // current time is after the start date?
            }
            return true;  // no start date set, so the notification bar is always on
        }

        /**
        * Returns true if the notification bar should be displayed based on the
        * end_date.
        * 
        * @return boolean true if either no end date is defined, or the current
        *         date is after the start date, false otherwise.
        */
        protected function _beforeEndDate() {
            list($year,$month,$day) = explode(',',Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_END_DATE));
            $str = null;
            if($year) {
                $str .= $year;
                if($month) {
                    $str .= "-".$month;
                    if($day) $str .= "-".$day;
                }

                return time() < strtotime($str);  // current time is before end date?
            }
            return true;  // no end date set, so the notification bar is always on
        }

}