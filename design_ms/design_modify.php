<?php

session_start();

$memberID = $_SESSION['memberID'];
$powerkey = $_SESSION['powerkey'];


require_once '/website/os/Mobile-Detect-2.8.34/Mobile_Detect.php';
$detect = new Mobile_Detect;


//載入公用函數
@include_once '/website/include/pub_function.php';

//連結資料
@include_once("/website/class/".$site_db."_info_class.php");

/* 使用xajax */
@include_once '/website/xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();

$xajax->registerFunction("processform");
function processform($aFormValues){

	$objResponse = new xajaxResponse();
	
	$web_id				= trim($aFormValues['web_id']);
	$auto_seq			= trim($aFormValues['auto_seq']);
	
	SaveValue($aFormValues);
	
	$objResponse->script("setSave();");
	$objResponse->script("parent.myDraw();");

	$objResponse->script("art.dialog.tips('已存檔!',1);");
	$objResponse->script("parent.$.fancybox.close();");
	$objResponse->script("parent.eModal.close();");
		
	
	return $objResponse;
}


$xajax->registerFunction("SaveValue");
function SaveValue($aFormValues){

	$objResponse = new xajaxResponse();
	
		//進行存檔動作
		$site_db					= trim($aFormValues['site_db']);
		$auto_seq					= trim($aFormValues['auto_seq']);
		$memberID					= trim($aFormValues['memberID']);
		$status1					= trim($aFormValues['status1']);
		$status2					= trim($aFormValues['status2']);
		$geto_no					= trim($aFormValues['geto_no']);
		$geto_quotation				= trim($aFormValues['geto_quotation']);
		$geto_order_date 			= trim($aFormValues['geto_order_date']);
		$geto_contract_date			= trim($aFormValues['geto_contract_date']);
		$geto_contact				= trim($aFormValues['geto_contact']);
		$geto_tel					= trim($aFormValues['geto_tel']);
		$estimated_delivery_date	= trim($aFormValues['estimated_delivery_date']);
		$geto_shipping_address      = trim($aFormValues['geto_shipping_address']);
		$geto_remark				= trim($aFormValues['geto_remark']);
		$geto_formwork			= trim($aFormValues['geto_formwork']);
		$material_import_date 	= trim($aFormValues['material_import_date']);
		$material_purchase_progress			= trim($aFormValues['material_purchase_progress']);

		//$confirm5				= trim($aFormValues['confirm5']);
		
		//存入info實體資料庫中
		$mDB = "";
		$mDB = new MywebDB();

		$Qry="UPDATE CaseManagement set
				 status1						= '$status1'
				,status2						= '$status2'
				,geto_no						= '$geto_no'
				,geto_quotation					= '$geto_quotation'
				,geto_order_date 				= '$geto_order_date'
				,geto_contract_date				= '$geto_contract_date'
				,geto_contact					= '$geto_contact'
				,geto_tel						= '$geto_tel'
				,estimated_delivery_date		= '$estimated_delivery_date'
				,geto_shipping_address			= '$geto_shipping_address'
				,geto_remark					= '$geto_remark'
				,geto_formwork					= '$geto_formwork'
				,material_import_date 			= '$material_import_date'
				,material_purchase_progress		= '$material_purchase_progress'
				,makeby5						= '$memberID'
				,last_modify5					= now()
				where auto_seq = '$auto_seq'";
				
		$mDB->query($Qry);
        $mDB->remove();

		
	return $objResponse;
}

$xajax->processRequest();



$auto_seq = $_GET['auto_seq'];
$fm = $_GET['fm'];

$mess_title = $title;

//$pro_id = "com";


$mDB = "";
$mDB = new MywebDB();
$Qry="SELECT a.*,b.employee_name,c.engineering_name,d.builder_name,e.contractor_name,f.company_name,f.short_name FROM CaseManagement a
LEFT JOIN employee b ON b.employee_id = a.Handler
LEFT JOIN construction c ON c.construction_id = a.construction_id
LEFT JOIN builder d ON d.builder_id = a.builder_id
LEFT JOIN contractor e ON e.contractor_id = a.contractor_id
LEFT JOIN company f ON f.company_id = a.company_id
WHERE a.auto_seq = '$auto_seq'";
$mDB->query($Qry);
$total = $mDB->rowCount();
if ($total > 0) {
    //已找到符合資料
	$row=$mDB->fetchRow(2);
	$status1 = $row['status1'];
	$status2 = $row['status2'];
	$region = $row['region'];
	$case_id = $row['case_id'];
	$construction_id = $row['construction_id'];
	$engineering_name = $row['engineering_name'];
	$builder_id = $row['builder_id'];
	$builder_name = $row['builder_name'];
	$contractor_id = $row['contractor_id'];
	$contractor_name = $row['contractor_name'];
	$contact = $row['contact'];
	$site_location = $row['site_location'];
	$county = $row['county'];
	$town = $row['town'];
	$zipcode = $row['zipcode'];
	$address = $row['address'];
	$ContractingModel = $row['ContractingModel'];
	$Handler = $row['Handler'];
	$Handler_name = $row['employee_name'];
	$buildings = $row['buildings'];
	$first_review_date = $row['first_review_date'];
	$estimated_return_date = $row['estimated_return_date'];
	$preliminary_status = $row['preliminary_status'];
	$remark = $row['remark'];

	$company_id = $row['company_id'];
	$company_name = $row['short_name'];
	if (empty($company_name))
		$company_name = $row['company_name'];

	$engineering_qty = $row['engineering_qty'];
	$std_layer_template_qty = $row['std_layer_template_qty'];
	$roof_protrusion_template_qty = $row['roof_protrusion_template_qty'];
	$material_amt = $row['material_amt'];
	$OEM_cost = $row['OEM_cost'];
	$quotation_amt = $row['quotation_amt'];
	$quotation_sended = $row['quotation_sended'];
	$quotation_date = $row['quotation_date'];
	$estimated_arrival_date = $row['estimated_arrival_date'];
	$actual_entry_date = $row['actual_entry_date'];
	$completion_date = $row['completion_date'];

	$contract_date = $row['contract_date'];
	$advance_payment1 = $row['advance_payment1'];
	$estimated_payment_date1 = $row['estimated_payment_date1'];
	$request_date1 = $row['request_date1'];
	$advance_payment2 = $row['advance_payment2'];
	$estimated_payment_date2 = $row['estimated_payment_date2'];
	$request_date2 = $row['request_date2'];
	$advance_payment3 = $row['advance_payment3'];
	$estimated_payment_date3 = $row['estimated_payment_date3'];
	$request_date3 = $row['request_date3'];


	$geto_no = $row['geto_no'];
	$geto_quotation = $row['geto_quotation'];
	$geto_order_date = $row['geto_order_date'];
	$geto_contract_date = $row['geto_contract_date'];
	$geto_contact = $row['geto_contact'];
	$geto_tel = $row['geto_tel'];
	$estimated_delivery_date = $row['estimated_delivery_date'];
	$geto_shipping_address = $row['geto_shipping_address'];
	$geto_remark= $row['geto_remark'];
	$geto_formwork = $row['geto_formwork'];
	$material_import_date = $row['material_import_date'];
	$material_purchase_progress = $row['material_purchase_progress'];

	$makeby5 = $row['makeby5'];
	$last_modify5 = $row['last_modify5'];
	//$confirm5 = $row['confirm5'];

	//if ($confirm5=="Y")
	//  $m_confirm5 = "checked=\"checked\"";


}


$pro_id = "geto_formwork";
//載入鋁模材料
$Qry="select caption from items where pro_id = '$pro_id' order by pro_id,orderby";
$mDB->query($Qry);
$select_geto_formwork = "";
$select_geto_formwork .= "<option></option>";

if ($mDB->rowCount() > 0) {
	while ($row=$mDB->fetchRow(2)) {
		$ch_caption = $row['caption'];
		$select_geto_formwork .= "<option value=\"$ch_caption\" ".mySelect($ch_caption,$geto_formwork).">$ch_caption</option>";
	}
}


$pro_id = "material_purchase_progress";
//載入材料採購進度
$Qry="select caption from items where pro_id = '$pro_id' order by pro_id,orderby";
$mDB->query($Qry);
$select_material_purchase_progress = "";
$select_material_purchase_progress .= "<option></option>";

if ($mDB->rowCount() > 0) {
	while ($row=$mDB->fetchRow(2)) {
		$ch_caption = $row['caption'];
		$select_material_purchase_progress .= "<option value=\"$ch_caption\" ".mySelect($ch_caption,$material_purchase_progress).">$ch_caption</option>";
	}
}



$getsmallclass = "/smarty/templates/$site_db/$templates/sub_modal/base/pjclass_ms/getsmallclass.php";
$getmainclass = "/smarty/templates/$site_db/$templates/sub_modal/base/pjclass_ms/getmainclass.php";


$pro_id = "CaseManagement";
//載入主類別選項
$Qry="select caption from pjclass where pro_id = '$pro_id' and small_class = '0' order by orderby";
$mDB->query($Qry);
$select_status1 = "";
$select_status1 .= "<option></option>";

if ($mDB->rowCount() > 0) {
    while ($row=$mDB->fetchRow(2)) {
		$mc_caption = $row['caption'];
		$select_status1 .= "<option value=\"$mc_caption\" ".mySelect($mc_caption,$status1).">$mc_caption</option>";
	}
}
//檢查並設定細類
//先取出 caption () 的 main_class 值
$m_row = getkeyvalue2($site_db."_info","pjclass","pro_id = '$pro_id' and small_class = '0' and caption = '$status1'","main_class");
$main_class_seq = $m_row['main_class'];
//從資料庫中讀取主類別資料
$Qry="select caption from pjclass where pro_id = '$pro_id' and main_class = '$main_class_seq' and small_class <> '0' order by orderby";
$select_status2 = "";
$select_status2 .= "<option></option>";
$mDB->query($Qry);
if ($mDB->rowCount() > 0) {
	while ($row=$mDB->fetchRow(2)) {
		$sc_caption = $row['caption'];
		$select_status2 .= "<option value=\"$sc_caption\" ".mySelect($sc_caption,$status2).">$sc_caption</option>";
	}
}	


$mDB->remove();


$show_savebtn=<<<EOT
<div class="btn-group vbottom" role="group" style="margin-top:5px;">
	<button id="save" class="btn btn-primary" type="button" onclick="CheckValue(this.form);" style="padding: 5px 15px;"><i class="bi bi-check-circle"></i>&nbsp;存檔</button>
	<button id="cancel" class="btn btn-secondary display_none" type="button" onclick="setCancel();" style="padding: 5px 15px;"><i class="bi bi-x-circle"></i>&nbsp;取消</button>
	<button id="close" class="btn btn-danger" type="button" onclick="parent.myDraw();parent.$.fancybox.close();" style="padding: 5px 15px;"><i class="bi bi-power"></i>&nbsp;關閉</button>
</div>
EOT;


if (!($detect->isMobile() && !$detect->isTablet())) {
	$isMobile = 0;
	
$style_css=<<<EOT
<style>

.card_full {
    width: 100%;
	height: 100vh;
}

#full {
    width: 100%;
	height: 100vh;
}

#info_container {
	width: 900px !Important;
	margin: 0 auto !Important;
}

.field_div1 {width:250px;display: none;font-size:18px;color:#000;text-align:right;font-weight:700;padding:15px 10px 0 0;vertical-align: top;display:inline-block;zoom: 1;*display: inline;}
.field_div2 {width:100%;max-width:630px;display: none;font-size:18px;color:#000;text-align:left;font-weight:700;padding:8px 0 0 0;vertical-align: top;display:inline-block;zoom: 1;*display: inline;}

.code_class {
	width:250px;
	text-align:right;
	padding:0 10px 0 0;
}

.custom-pointer {
  cursor: pointer;
}

</style>

EOT;

} else {
	$isMobile = 1;

$style_css=<<<EOT
<style>

.card_full {
    width: 100vw;
	height: 100vh;
}

#full {
    width: 100vw;
	height: 100vh;
}

#info_container {
	width: 100% !Important;
	margin: 0 auto !Important;
}

.field_div1 {width:100%;display: block;font-size:18px;color:#000;text-align:left;font-weight:700;padding:15px 10px 0 0;vertical-align: top;}
.field_div2 {width:100%;display: block;font-size:18px;color:#000;text-align:left;font-weight:700;padding:8px 10px 0 0;vertical-align: top;}

.code_class {
	width:auto;
	text-align:left;
	padding:0 10px 0 0;
}

</style>
EOT;

}


$show_center=<<<EOT

$style_css

<div class="card card_full">
	<div class="card-header text-bg-info">
		<div class="size14 weight float-start" style="margin-top: 5px;">
			$mess_title
		</div>
		<div class="float-end" style="margin-top: -5px;">
			$show_savebtn
		</div>
	</div>
	<div id="full" class="card-body data-overlayscrollbars-initialize">
		<div id="info_container">
			<form method="post" id="modifyForm" name="modifyForm" enctype="multipart/form-data" action="javascript:void(null);">
			<div class="w-100 mb-5">
				<div class="field_container3">
					<div>
						<div class="field_div1">狀態:</div> 
						<div class="field_div2">
							<div class="inline text-nowrap mb-1">
								(1):
								<select id="status1" name="status1" style="width:150px;" onchange="setEdit();">
									$select_status1
								</select>
							</div>
							<div class="inline text-nowrap mb-1">
								(2):
								<select id="status2" name="status2" style="width:150px;">
									$select_status2
								</select>
							</div>
						</div> 
					</div>
					<div>
						<div class="field_div2">
							<div class="my-1">
								<div class="inline code_class">工程案件:</div>
								<div class="inline blue weight me-2">$case_id</div>
								<div class="inline blue weight me-2">$region</div>
								<div class="inline blue weight me-2">$construction_id</div>
								<div class="inline"><i id="expand" class="bi bi-caret-down-fill gray custom-pointer" title="展開"></i></div>
							</div>
							<div id="content" class="w-100 display_none">
								<div class="mytable w-100">
									<div class="myrow">
										<div class="mycell code_class">上包-建商名稱:</div>
										<div class="mycell blue weight">
											<div class="inline blue weight">$builder_name</div>
											<div class="inline size08 gray">$builder_id</div>
										</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">上包-營造廠名稱:</div>
										<div class="mycell blue weight">
											<div class="inline blue weight">$contractor_name</div>
											<div class="inline size08 gray">$contractor_id</div>
										</div>
									</div>
									<!--
									<div class="myrow">
										<div class="mycell code_class">連絡人:</div>
										<div class="mycell blue weight">$contact</div>
									</div>
									-->
									<div class="myrow">
										<div class="mycell code_class">案場位置:</div>
										<div class="mycell blue weight">{$zipcode}{$county}{$town}{$address}</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">承攬模式:</div>
										<div class="mycell blue weight">$ContractingModel</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">所屬公司:</div>
										<div class="mycell blue weight">
											<div class="inline blue weight">$company_name</div>
											<div class="inline size08 gray">$company_id</div>
										</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">經辦人員:</div>
										<div class="mycell blue weight">
											<div class="inline blue weight">$Handler_name</div>
											<div class="inline size08 gray">$Handler</div>
										</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">建物棟數:</div>
										<div class="mycell blue weight">$buildings</div>
									</div>
									<!--
									<div class="myrow">
										<div class="mycell code_class">初評發送日期:</div>
										<div class="mycell blue weight">$first_review_date</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">預計回饋日期:</div>
										<div class="mycell blue weight">$estimated_return_date</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">初評狀態:</div>
										<div class="mycell blue weight">$preliminary_status</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">備註:</div>
										<div class="mycell blue weight">$remark</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">工程量(M2):</div>
										<div class="mycell blue weight">$engineering_qty</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">標準層模板數量(M2):</div>
										<div class="mycell blue weight">$std_layer_template_qty</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">屋突層模板數量(M2):</div>
										<div class="mycell blue weight">$roof_protrusion_template_qty</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">材料金額:</div>
										<div class="mycell blue weight">$material_amt</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">代工費用:</div>
										<div class="mycell blue weight">$OEM_cost</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">報價金額(未稅):</div>
										<div class="mycell blue weight">$quotation_amt</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">報價單是否送出:</div>
										<div class="mycell blue weight">$quotation_sended</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">報價日期:</div>
										<div class="mycell blue weight">$quotation_date</div>
									</div>
									-->
									<div class="myrow">
										<div class="mycell code_class">預計進場日期:</div>
										<div class="mycell blue weight">$estimated_arrival_date</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">實際進場日期:</div>
										<div class="mycell blue weight">$actual_entry_date</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">預計完工日:</div>
										<div class="mycell blue weight">$completion_date</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">上包合約簽訂日期:</div>
										<div class="mycell blue weight">$contract_date</div>
									</div>
									<!--
									<div class="myrow">
										<div class="mycell code_class">第一期預付款請款方式:</div>
										<div class="mycell blue weight">$advance_payment1</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">第一期預付預估日期:</div>
										<div class="mycell blue weight">$estimated_payment_date1</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">第一期請款日期:</div>
										<div class="mycell blue weight">$request_date1</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">第二期預付款請款方式:</div>
										<div class="mycell blue weight">$advance_payment2</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">第二期預付預估日期:</div>
										<div class="mycell blue weight">$estimated_payment_date2</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">第二期請款日期:</div>
										<div class="mycell blue weight">$request_date2</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">第三期預付款請款方式:</div>
										<div class="mycell blue weight">$advance_payment3</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">第三期預付預估日期:</div>
										<div class="mycell blue weight">$estimated_payment_date3</div>
									</div>
									<div class="myrow">
										<div class="mycell code_class">第三期請款日期:</div>
										<div class="mycell blue weight">$request_date3</div>
									</div>
									-->
								</div>
							</div>
						</div> 
					</div>
					<div>
						<div class="field_div1">志特編號:</div> 
						<div class="field_div2">
							<input type="text" class="inputtext" id="geto_no" name="geto_no" size="20" maxlength="50" style="width:100%;max-width:250px;" value="$geto_no" onchange="setEdit();"/>
						</div> 
					</div>
					<div>
						<div class="field_div1">志特報價:</div> 
						<div class="field_div2">
							<input type="text" class="inputtext" id="geto_quotation" name="geto_quotation" size="20" style="width:100%;max-width:250px;" value="$geto_quotation" onchange="setEdit();"/>
						</div> 
					</div>
					<div>
						<div class="field_div1">請志特報價日期:</div> 
						<div class="field_div2">
							<div class="input-group" id="geto_order_date" style="width:100%;max-width:250px;">
								<input type="text" class="form-control" name="geto_order_date" placeholder="請輸入下單志特日期" aria-describedby="geto_order_date" value="$geto_order_date">
								<button class="btn btn-outline-secondary input-group-append input-group-addon" type="button" data-target="#geto_order_date" data-toggle="datetimepicker"><i class="bi bi-calendar"></i></button>
							</div>
							<script type="text/javascript">
								$(function () {
									$('#geto_order_date').datetimepicker({
										locale: 'zh-tw'
										,format:"YYYY-MM-DD"
										,allowInputToggle: true
									});
								});
							</script>
						</div> 
					</div>
					<div>
						<div class="field_div1">志特合約簽訂日期:</div> 
						<div class="field_div2">
							<div class="input-group" id="geto_contract_date" style="width:100%;max-width:250px;">
								<input type="text" class="form-control" name="geto_contract_date" placeholder="請輸入志特合約簽訂日期" aria-describedby="geto_contract_date" value="$geto_contract_date">
								<button class="btn btn-outline-secondary input-group-append input-group-addon" type="button" data-target="#geto_contract_date" data-toggle="datetimepicker"><i class="bi bi-calendar"></i></button>
							</div>
							<script type="text/javascript">
								$(function () {
									$('#geto_contract_date').datetimepicker({
										locale: 'zh-tw'
										,format:"YYYY-MM-DD"
										,allowInputToggle: true
									});
								});
							</script>
						</div> 
					</div>
					<div>
						<div class="field_div1">志特聯絡方式:</div> 
						<div class="field_div2">
							<div class="inline text-nowrap mb-1">
								聯絡人:
								<input id="geto_contact" name="geto_contact" style="width:150px;" value="$geto_contact" onchange="setEdit();"/>
							</div>
							<div class="inline text-nowrap mb-1">
								聯絡電話:
								<input id="geto_tel" name="geto_tel" style="width:150px;" value="$geto_tel" onchange="setEdit();"/>
							</div>
						</div> 
					</div>
					<div>
						<div class="field_div1">預計領櫃日期:</div> 
						<div class="field_div2">
							<div class="input-group" id="estimated_delivery_date" style="width:100%;max-width:250px;">
								<input type="text" class="form-control" name="estimated_delivery_date" placeholder="請輸入預計領櫃日期" aria-describedby="estimated_delivery_date" value="$estimated_delivery_date">
								<button class="btn btn-outline-secondary input-group-append input-group-addon" type="button" data-target="#estimated_delivery_date" data-toggle="datetimepicker"><i class="bi bi-calendar"></i></button>
							</div>
							<script type="text/javascript">
								$(function () {
									$('#estimated_delivery_date').datetimepicker({
										locale: 'zh-tw'
										,format:"YYYY-MM-DD"
										,allowInputToggle: true
									});
								});
							</script>
						</div> 
					</div>
					<div>
						<div class="field_div1">送貨地址:</div> 
						<div class="field_div2">
							<input type="text" class="inputtext" id="geto_shipping_address" name="geto_shipping_address" size="20" style="width:100%;max-width:250px;" value="$geto_shipping_address" onchange="setEdit();"/>
						</div> 
					</div>
					<div>
						<div class="field_div1">鋁模材料:</div> 
						<div class="field_div2">
							<select id="geto_formwork" name="geto_formwork" placeholder="請選擇鋁模材料" style="width:100%;max-width:350px;">
								$select_geto_formwork
							</select>
						</div> 
					</div>
					<div>
						<div class="field_div1">材料進口日期:</div> 
						<div class="field_div2">
							<div class="input-group" id="material_import_date" style="width:100%;max-width:250px;">
								<input type="text" class="form-control" name="material_import_date" placeholder="請輸入材料進口日期" aria-describedby="material_import_date" value="$material_import_date">
								<button class="btn btn-outline-secondary input-group-append input-group-addon" type="button" data-target="#material_import_date" data-toggle="datetimepicker"><i class="bi bi-calendar"></i></button>
							</div>
							<script type="text/javascript">
								$(function () {
									$('#material_import_date').datetimepicker({
										locale: 'zh-tw'
										,format:"YYYY-MM-DD"
										,allowInputToggle: true
									});
								});
							</script>
						</div> 
					</div>
					<div>
						<div class="field_div1">材料採購進度:</div> 
						<div class="field_div2">
							<select id="material_purchase_progress" name="material_purchase_progress" placeholder="請選擇材料採購進度" style="width:100%;max-width:350px;">
								$select_material_purchase_progress
							</select>
						</div> 
					</div>
					<div>
						<div class="field_div1">備註:</div> 
						<div class="field_div2">
							<textarea class="inputtext w-100 p-3" id="geto_remark" name="geto_remark" cols="80" rows="2" style="max-width: 500px;" onchange="setEdit();">$geto_remark</textarea>
						</div> 
					</div>

					<!--
					<div>
						<div class="field_div1">設定:</div> 
						<div class="field_div2 pt-3">
							<input type="checkbox" class="inputtext" name="confirm5" id="confirm5" value="Y" $m_confirm5 />
							<label for="confirm5" class="red">確認</label>
						</div>
					</div>
					-->
					<div>
						<input type="hidden" name="fm" value="$fm" />
						<input type="hidden" name="site_db" value="$site_db" />
						<input type="hidden" name="auto_seq" value="$auto_seq" />
						<input type="hidden" name="memberID" value="$memberID" />
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<script>

function CheckValue(thisform) {
	xajax_processform(xajax.getFormValues('modifyForm'));
	thisform.submit();
}

function SaveValue(thisform) {
	xajax_SaveValue(xajax.getFormValues('modifyForm'));
	thisform.submit();
}

function setEdit() {
	$('#close', window.document).addClass("display_none");
	$('#cancel', window.document).removeClass("display_none");
}

function setCancel() {
	$('#close', window.document).removeClass("display_none");
	$('#cancel', window.document).addClass("display_none");
	document.forms[0].reset();
}

function setSave() {
	$('#close', window.document).removeClass("display_none");
	$('#cancel', window.document).addClass("display_none");
}

$(document).ready(function () {
  $("#expand").on("click", function () {
    // 切換展開/摺疊內容
    let content = $("#content"); // 假設展開的內容有 id 為 content
    content.toggleClass("display_none");

    // 切換圖示方向
    $(this).toggleClass("bi-caret-down-fill bi-caret-up-fill");

    // 更新 title 提示文字
    let newTitle = content.hasClass("display_none") ? "展開" : "摺疊";
    $(this).attr("title", newTitle);
  });
});



function getSelectVal(){ 
	$("option",status2).remove(); //清空原有的選項
	var main_class_val = $("#status1").val();
    $.getJSON('$getsmallclass',{main_class:main_class_val,site_db:'$site_db',pro_id:'$pro_id'},function(json){ 
        var small_class = $("#status2"); 
        var option = "<option></option>";
		small_class.append(option);
        $.each(json,function(index,array){ 
			option = "<option value='"+array['caption']+"'>"+array['caption']+"</option>"; 
            small_class.append(option); 
        }); 
    });
}

$(function(){ 
    $("#status1").change(function(){ 
        getSelectVal(); 
    }); 
});


//更新主類別
function getMainSelectVal(){ 
    $.getJSON("$getmainclass",{site_db:'$site_db',pro_id:'$pro_id'},function(json){ 
        var main_class = $("#status1"); 
		var last_option = main_class.val();
        $("option",status1).remove(); //清空原有的選項
        var option = "<option></option>";
		main_class.append(option);
        $.each(json,function(index,array){
			if (array['caption'] == last_option)
				option = "<option value='"+array['caption']+"' selected>"+array['caption']+"</option>"; 
			else
				option = "<option value='"+array['caption']+"'>"+array['caption']+"</option>"; 
            main_class.append(option); 
        }); 
    }); 
}


$(document).ready(async function() {
	//等待其他資源載入完成，此方式適用大部份瀏覽器
	await new Promise(resolve => setTimeout(resolve, 100));
	$('#status1').focus();
});

</script>

EOT;

?>