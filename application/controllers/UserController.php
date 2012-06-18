<?php

/**
 * Description of UserController
 *
 * @author RyanChan
 */
class UserController extends MR_Rest_Controller {

    /**
     *
     * @var MR\Entity\Repository\UserRepository $userRepository
     */
    protected $userRepository = null;

    public function init() {
        parent::init();

        $this->userRepository = $this->em->getRepository('MR\Entity\User');
    }

    /**
     * Return all users with detailed informations
     * 
     * [
     *  {
     *      id: user id,
     *      username: username,
     *      role: {
     *          id: role id,
     *          name: role name,
     *      },
     *      ts_created: created datetime,
     *      ts_last_updated: last updated datetime,
     *      profile:[
     *          {
     *              profile_key: first name
     *              profile_value: Ryan
     *          },
     *          {
     *              profile_key: last name
     *              profile_value: Chan
     *          }
     *      ]
     *  }
     * ]
     * 
     * Return as Zend_Json format 
     */
    public function indexAction() {
        $data = array();

        $users = $this->userRepository->findAll();

        if (count($users) > 0) {
            foreach ($users as $index => $user) {
                $data[$index] = array(
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'role' => array(
                        'id' => $user->getRole()->getId(),
                        'name' => $user->getRole()->getName(),
                    ),
                    'ts_created' => $user->getCreated()->format('Y-m-d H:i:s'),
                );

                $profiles = $user->getProfiles();
                foreach ($profiles as $profile) {
                    $data[$index]['profile'][] = array(
                        'profile_key' => $profile->getProfileKey(),
                        'profile_value' => $profile->getProfileValue()
                    );
                }
            }

            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_OK);
            $this->getResponse()->setBody(Zend_Json::encode($data));
        } else {
            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_NOT_FOUND);
        }
    }

    public function getAction() {
        $id = $this->_getParam('id');
        if ($id > 0) {
            $user = $this->userRepository->find($id);
            if ($user) {
                $data = array(
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'role' => array(
                        'id' => $user->getRole()->getId(),
                        'name' => $user->getRole()->getName(),
                    ),
                    'ts_created' => $user->getCreated()->format('Y-m-d H:i:s'),
                );

                $profiles = $user->getProfiles();
                foreach ($profiles as $profile) {
                    $data['profile'][] = array(
                        'profile_key' => $profile->getProfileKey(),
                        'profile_value' => $profile->getProfileValue()
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

    public function postAction() {
        parent::postAction();
    }

    public function putAction() {
        parent::putAction();
    }

    public function deleteAction() {
        $id = $this->_getParam('id');
        if ($id > 0) {
            $user = $this->userRepository->find($id);
            if ($user) {
                $this->em->remove($user);
                $this->em->flush();
                
                $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_OK);
                
            }else{
                $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_NOT_FOUND);
            }
        } else {
            $this->getResponse()->setHttpResponseCode(MR_Http_Code::CODE_BAD_REQUEST);
        }
    }

}
