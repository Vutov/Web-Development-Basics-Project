<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/17/15
 * Time: 2:17 AM
 */

namespace Routers;

use FTS\Routers\IRouter;

include '../../FTS-Framework/Routers/IRouter.php';

class DummyRouter implements IRouter{

    /**
     * @return 'package/controller/method/param[0]/param[1]
     */
    public function getURI()
    {
        // TODO: fix dummy router
        return 'admin/index2/new';
    }

    public function getPost()
    {
        return array('Dummy' => 'Router');
    }
}