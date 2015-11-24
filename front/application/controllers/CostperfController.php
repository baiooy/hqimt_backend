<?php
/*
 * 性价比
 */
class CostperfController extends Zend_Controller_Action
{

	public function init(){
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
	}
	
	/*
	 * 导航首页
	 */
	public function indexAction(){
/*	    
		$departmentsCategorys = Application_Model_M_DepartmentsCategory::fetchByStatus(1);
		if(count($departmentsCategorys)>0){
			$out['errno'] = '0';
			$results = array();
			foreach ($departmentsCategorys as $departmentsCategory){
				$result = array(
						'id'	=> $departmentsCategory->getId(),
						'name'	=> $departmentsCategory->getName(),
						'img'	=> $departmentsCategory->getImg(),
						);
				//获取该分类下的列表
				$departments = Application_Model_M_Departments::fetchByCID($departmentsCategory->getId());
				$list	= "";
				if(count($departments)>0){
					foreach ($departments as $department){
						$name = $department->getName();
						$list .= $name;
					}
				}
				$result['list']	= $list;
				array_push($results, $result);
			}
			$out['costperfs'] =  $results;
		}else{
			$out['errno'] = '1';
		}
		$out['msg'] = Yy_ErrMsg_Costperf::getMsg('index', $out['errno']);
		Yy_Utils::jsonOut($out);
*/
	    $page = $this->_getParam('page',1);
	    $data = Application_Model_M_Departments::fetchByStatus(1,$page,30);
	    //var_dump($data);exit;
	    $pages = $data['pages'];
	    $departs = $data['departments'];
	    if(count($departs) > 0){
	    	$out['errno'] = "0";
	    	if($page < $pages){
	    		$out['page']  = $page;
	    	}else{
	    		$out['page'] = $pages;
	    	}
	    	$out['pages'] = $pages;
 	    	$results = array();
	    	foreach ($departs as $depart){
	    		$result = array(
	    			    'id'    => $depart->getId(),
	    		        'name'  => $depart->getName(),
	    		        'img'   => Application_Model_M_Departments::getImageUrl($depart->getId()),
	    		         );
	    		array_push($results, $result);
	    	}
	    	$out['departments']   = $results;
	    }else{
	    	$out['errno'] = "1";
	    	
	    }
	    $out['msg'] = Yy_ErrMsg_Costperf::getMsg('index', $out['errno']);
	    Yy_Utils::jsonOut($out);
	}
/*	
	public function priceAction(){
		$id	= $this->_getParam('id'); //category_id
		//out name/price/id
		$departments = Application_Model_M_Departments::fetchByCID($id);
		if(count($departments)>0){
			$out['errno'] = '0';
			$results	= array();
			foreach ($departments as $department){
				$result	= array(
						'id'	=> $department->getId(),
						'name'	=> $department->getName(),
						);
				$avgPrice	= Application_Model_M_DepartmentsHospitalMap::fetchAvgpriceByDID($department->getId());
				if($avgPrice != 0){
					$result['price']	= $avgPrice;
				}else{
					if(@$_GET['lang'] == 1){
						$result['price']	= 'nothing';
					}else{						
						$result['price']	= '暂无';
					}
				}
				array_push($results, $result);
			}
			$out['lists']	= $results;
			
		}else{
			$out['errno'] = '1';
		}
		$out['msg'] = Yy_ErrMsg_Costperf::getMsg('price', $out['errno']);
		Yy_Utils::jsonOut($out);
	}
*/	
	/*
	 * 1项目介绍，2成功案例
	 */
	public function detailAction(){
		$id	= $this->_getParam('id');
		$type = $this->_getParam('type');//1项目介绍，2成功案例
		$additionals = Application_Model_M_DepartmentsAdditional::fetchByDepartmentIDAndType($id,$type);
		if(count($additionals)>0){
			$out['errno'] = '0';
			$details = array();
			foreach ($additionals as $additional){
				$detail = array(
						'title'     => $additional->getTitle(),
						'content'   => $additional->getContent(),
						'img'       => Application_Model_M_DepartmentsAdditional::getImageUrl($additional->getId()),
				);
				array_push($details, $detail);
			}
			$out['details']   = $details;
		}else{
			$out['errno'] = '1';
		}
		$out['msg'] = Yy_ErrMsg_Costperf::getMsg('detail', $out['errno']);
		Yy_Utils::jsonOut($out);
	}
	
	/*
	 * 手术详情页图片
	 */
	public function imageAction(){
		$this->getResponse()->setHeader('Content-Type', 'image/png');
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		 
		$id = $this->_getParam('id');
		$img = Application_Model_M_Departments::getImage($id);
		echo $img;
	}
	
	public function addiimageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_DepartmentsAdditional::getImage($id);
    	echo $img;
    } 
	
	
	/*
	 * 推荐医院
	 */
	public function hospitalAction(){
	    $id	= $this->_getParam('id'); //department_id
	    $hospitalMaps = Application_Model_M_DepartmentsHospitalMap::fetchByDepartmentID($id);
	    if(count($hospitalMaps)>0){
	    	$hospitals	= array();
	    	foreach ($hospitalMaps as $hospitalMap){
	    		$hospitalID = $hospitalMap->getHospital_id();
	    		$hospitalModel	= Application_Model_M_Hospital::find($hospitalID);
	    		if($hospitalModel && $hospitalModel->getStatus() == 1){
	    			$hospital = array(
	    					'id'	=> $hospitalModel->getId(),
	    					'name'	=> $hospitalModel->getName(),
	    					'avatar'=> Application_Model_M_Hospital::getAvatarUrl($hospitalModel->getId()),
	    					'type'	=> $hospitalModel->getType(),
	    					'departments'	=> $hospitalModel->getDepartments(),
							'longitude'	=> $hospitalModel->getLongitude(),
							'latitude'	=> $hospitalModel->getLatitude(),
	    			);
	    			array_push($hospitals, $hospital);
	    		}
	    	}
	    	if(count($hospitals)>0){
	    		$out['errno'] = '0';
	    		$out['hospitals'] = $hospitals;
	    	}else{
	    		$out['errno'] = '1';
	    	}
	    }else{
	    	$out['errno'] = '1';
	    }
	    $out['msg'] = Yy_ErrMsg_Costperf::getMsg('hospital', $out['errno']);
	    Yy_Utils::jsonOut($out);
	}
	
	/*
	 * 推荐行程
	*/
	public function travelAction(){
		$id	= $this->_getParam('id');//department_id
		$travelMaps   = Application_Model_M_DepartmentsTravelMap::fetchByDepartID($id);
		if(count($travelMaps)>0){
			$travels   = array();
			foreach ($travelMaps as $travelMap){
				$travelID = $travelMap->getTravel_id();
				$travel  = Application_Model_M_Travel::find($travelID);
				if($travel && $travel->getStatus() == 1){
					$result  = array(
							'id'        => $travel->getId(),
							'title'     => $travel->getTitle(),
							'subtitle'  => $travel->getSubtitle(),
							'img'       => Application_Model_M_Travel::getImageUrl($travel->getId()),
							'adult_oprice'   => $travel->getAdult_oprice(),
							'adult_dprice'   => $travel->getAdult_dprice(),
							'child_oprice'   => $travel->getChild_oprice(),
							'child_dprice'   => $travel->getChild_dprice(),
							'area'     => $travel->getArea(),
							'sales'    => $travel->getSales(),
					);
					array_push($travels, $result);
				}
			}
			if(count($travels)>0){
				$out['errno'] = '0';
				$out['travels'] = $travels;
			}else{
				$out['errno'] = '1';
			}
		}else{
			$out['errno'] = '1';
		}
		$out['msg'] = Yy_ErrMsg_Costperf::getMsg('travel', $out['errno']);
		Yy_Utils::jsonOut($out);
	}
}