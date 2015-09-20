<h1>Admin</h1>
<h2>Index page</h2>
<div>Username: <?= $this->_viewBag['body']->getName() ?> </div>
<div>Password: <?= $this->_viewBag['body']->getPassword() ?> </div>
<div>Is Admin: <?= $this->_viewBag['body']->getAdmin() ?> </div>
