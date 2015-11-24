<?php
/*
 * 项目分类
 */
class DepartmentController extends Zend_Controller_Action{

	public function init(){
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
	}
	
	/*
	 * 获取分类
	 */
	public function categoryAction(){
		$categorys    = Application_Model_M_ConsultationDepartmentsCategory::fetchByStatus(1);
		if(count($categorys)>0){
			$out['errno'] = '0';
			$results = array();
			foreach ($categorys as $category){
				$result = array(
					   'id'    => $category->getId(),
				       'name'  => $category->getName(),
				        );
				array_push($results, $result);
			}
			$out['categorys'] = $results;
		}else{
			$out['errno'] = '1';
		}
		$out['msg'] = Yy_ErrMsg_Department::getMsg('category', $out['errno']);
		Yy_Utils::jsonOut($out);
	}
	/*
	 * 获取分类下的department
	 */
	public function departmentAction(){
		$id   = $this->_getParam('id');
		$departments  = Application_Model_M_ConsultationDepartments::fetchByCID($id);
		if(count($departments)>0){
			$out['errno'] = '0';
			$results = array();
			foreach ($departments as $department){
				$result = array(
					      'id'      => $department->getId(),
				          'name'    => $department->getName(),
				          ); 
				array_push($results, $result);   
			}
			$out['departments']   = $results;
		}else{
			$out['errno'] = '1';
		}
		$out['msg'] = Yy_ErrMsg_Department::getMsg('department', $out['errno']);
		Yy_Utils::jsonOut($out);
		
	}
}