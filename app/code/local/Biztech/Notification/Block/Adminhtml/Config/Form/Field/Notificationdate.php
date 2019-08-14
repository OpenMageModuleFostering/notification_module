<?php
   
    class Biztech_Notification_Block_Adminhtml_Config_Form_Field_Notificationdate extends Mage_Adminhtml_Block_System_Config_Form_Field
    {

        protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
        {
            $_years = array(null => "Year");
            for($i = 0, $y = (int)date("Y"); $i < 5; $i++, $y++) {
                $_years[$y] = $y;
            }

            $_months = array(null => "Month");
            $monthNames = array('January','February','March','April','May','June','July','August','September','October','November','December');
            for ($i = 1; $i <= 12; $i++) {
                $_months[$i] = $monthNames[$i-1];
            }

            $_days = array(null => "Day");
            for ($i = 1; $i <= 31; $i++) {
                $_days[$i] = $i < 10 ? '0'.$i : $i;
            }

            if ($element->getValue()) {
                $values = explode(',', $element->getValue());
            } else {
                $values = array();
            }

            $element->setName($element->getName() . '[]');

            $_yearsHtml = $element->setStyle('width:75px;')
            ->setValues($_years)
            ->setValue(isset($values[0]) ? $values[0] : null)
            ->getElementHtml();

            $_monthsHtml = $element->setStyle('width:100px;')
            ->setValues($_months)
            ->setValue(isset($values[1]) ? $values[1] : null)
            ->getElementHtml();

            $_daysHtml = $element->setStyle('width:50px;')
            ->setValues($_days)
            ->setValue(isset($values[2]) ? $values[2] : null)
            ->getElementHtml();

            return sprintf('%s %s %s', $_yearsHtml, $_monthsHtml, $_daysHtml);
        }
}