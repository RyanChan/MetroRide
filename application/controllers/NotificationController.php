<?php

require_once 'urbanairship.php';

/**
 * Description of NotificationController
 *
 * @author RyanChan
 */
class NotificationController extends MR_Rest_Controller {

    /**
     *
     * @var MR\Entity\Repository\LineNotificationRepository $lineNotificationRepository
     */
    protected $lineNotificationRepository = null;

    /**
     *
     * @var MR\Entity\Repository\LineRepository $lineRepository
     */
    protected $lineRepository = null;

    public function init() {
        parent::init();

        $this->lineNotificationRepository = $this->em->getRepository('MR\Entity\LineNotification');
        $this->lineRepository = $this->em->getRepository('MR\Entity\Line');
    }

    /**
     * Return each line status with simple data.
     * E.g, Chinese name, English name, Initial, Current level.
     * 
     * [
     *  {
     *      id:1, 
     *      initial:DRL,
     *      name:{
     *          english: Disney Line,
     *          chinese: 迪士尼線
     *      },
     *      level: 1,
     *      ts_last_updated: 2012-06-18 15:05:40
     *  },
     * ] 
     * 
     * Echo as Zend_Json format.    
     */
    public function indexAction() {
        $data = array();

        $lines = $this->lineRepository->findAll();
        if (count($lines) > 0) {
            foreach ($lines as $index => $line) {
                $data[$index] = array(
                    'id' => $line->getId(),
                    'initial' => $line->getInitial(),
                    'name' => array(
                        'chinese' => $line->getProfile('chinese_name')->getProfileValue(),
                        'english' => $line->getProfile('english_name')->getProfileValue(),
                    ),
                    'level' => $line->getCurrentLevel(),
                );
            }

            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_OK);
            $this->getResponse()->setBody(Zend_Json::encode($data));
        } else {
            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_NOT_FOUND);
        }
    }

    /**
     * Return specific Line's notifications
     * 
     * {
     *  id: 1,
     *  level: 1,
     *  content: {
     *      english: english content,
     *      chinese: chinese content,
     *  },
     *  ts_created: 2012-06-18 12:10:25
     * }
     *  
     * Return as Zend_Json format
     */
    public function getAction() {
        // Get Line ID
        $id = $this->_getParam('id');
        // Check $id whether greater than 0
        if ($id > 0) {
            $data = array();

            $line = $this->lineRepository->find($id);
            if ($line) {
                $notifications = $line->getNotification();
                foreach ($notifications as $index => $notification) {
                    $data[$index] = array(
                        'id' => $notification->getId(),
                        'level' => $notification->getLevel(),
                        'content' => array(
                            'chinese' => $notification->getContentZh(),
                            'english' => $notification->getContentEn(),
                        ),
                        'ts_created' => $notification->getCreated()->format('Y-m-d H:i:s'),
                    );
                }

                $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_OK);
                $this->getResponse()->setBody(Zend_Json::encode($data));
            } else {
                $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_NOT_FOUND);
            }
        } else {
            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_BAD_REQUEST);
        }
    }

    /**
     * Update specific line notification's information
     * 
     * @required LineNotification id
     * @Optional Line line_id
     * @Optional integer level
     * @Optional string content_en
     * @Optional string content_zh
     * 
     */
    public function putAction() {
        $id = $this->_getParam('id');
        if ($id > 0) {
            $notification = $this->lineNotificationRepository->find($id);
            if ($notification) {
                $line_id = $this->_getParam('line_id');
                // check if line id has changed
                if ($notification->getLine()->getId() != $line_id) {
                    $line = $this->lineRepository->find($line_id);
                    if ($line) {
                        $notification->setLine($line);
                    }
                }
                
//                print_r($this->_getAllParams());
//                echo $this->_getParam('level');
//                echo $notification->getLevel();
//                exit();
                $level = $this->_getParam('level');
                if ($notification->getLevel() != $level) {
                    $notification->setLevel($level);
                }

                $content_en = $this->_getParam('content_en');
                if ($notification->getContentEn() != $content_en) {
                    $notification->setContentEn($content_en);
                }

                $content_zh = $this->_getParam('content_zh');
                if ($notification->getContentZh() != $content_zh) {
                    $notification->setContentZh($content_zh);
                }

                $this->em->persist($notification);
                $this->em->flush();

                $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_OK);
            } else {
                $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_NOT_FOUND);
            }
        } else {
            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_BAD_REQUEST);
        }
    }

    /**
     * Delete specific notification
     * 
     * @required LineNotification id 
     */
    public function deleteAction() {
        $id = $this->_getParam('id');
        if ($id > 0) {
            $lineNotification = $this->lineNotificationRepository->find($id);
            if ($lineNotification) {
                $this->em->remove($lineNotification);
                $this->em->flush();

                $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_OK);
            } else {
                $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_NOT_FOUND);
            }
        } else {
            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_BAD_REQUEST);
        }
    }

    /**
     * Post a new notification to specific line
     * 
     * @Required Line id
     * @Required integer level
     * @Required string content_en
     * @Required string content_zh
     */
    public function postAction() {
        $lineNotification = new \MR\Entity\LineNotification();

        try {
            $id = $this->_getParam('id');
            
            $line = $this->lineRepository->find($id);
            if ($line) {
                $lineNotification->setLine($line);
            }
            
            $level = $this->_getParam('level');
            $lineNotification->setLevel($level);
            
            $content_en = $this->_getParam('content_en');
            $lineNotification->setContentEn($content_en);
            
            $content_zh = $this->_getParam('content_zh');
            $lineNotification->setContentZh($content_zh);
            
            $this->em->persist($lineNotification);
            $this->em->flush();
            
            // Push Notification Api
            $push = new MR_Airship();
            
            $payload = array(
                'aps' => array(
                    'alert' => $content_zh.' '.$content_en
                )
            );
            
            $push->broadcast($payload);
            
            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_CREATED);
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_BAD_REQUEST);
            $this->getResponse()->setBody($e->getMessage());
        }
    }

}
