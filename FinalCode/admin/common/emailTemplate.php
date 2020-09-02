<?php
 
function getTemplate($body,$startMessage,$title){

$template ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>'.$title.'</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">	
		<tr>
			<td style="padding: 10px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" style="padding: 0 0 0px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<img src="https://www.qhseinternational.com/wp-content/uploads/2020/03/QHSE-High-Res-e1585043114574.png" alt="Creating Email Magic" width="220" height="80" style="display: block;" />
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<b>'.$startMessage.'</b>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">'.$body.'
										
									</td>
								</tr>
								<tr>
									
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#000000" style="padding: 30px 30px 30px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;" width="100%">
										&reg; ©www.qhseinternational.com All Rights Reserved
									</td>
									<td align="right" width="15%" >
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>												
												
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="https://www.facebook.com/QHSEDubai/" target="_blank" style="color: #ffffff;">
														<img src="https://www.qhseinternational.com/wp-content/uploads/2020/03/facebook-new.jpg" alt="Facebook" width="30" height="30" style="display: block;" border="0" />
													</a>
												</td>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a  href="https://twitter.com/QHSEI" target="_blank" style="color: #ffffff;">
														<img src="https://www.qhseinternational.com/wp-content/uploads/2020/03/t-new.jpg" alt="Twitter" width="30" height="30" style="display: block;" border="0" />
													</a>
												</td>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a  href="https://www.instagram.com/qhse_international/" target="_blank"  style="color: #ffffff;">
														<img src="https://www.qhseinternational.com/wp-content/uploads/2020/03/insta-new.jpg" alt="Twitter" width="30" height="30" style="display: block;" border="0" />
													</a>
												</td>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="https://www.linkedin.com/company/3575282?trk=tyah&amp;trkInfo=clickedVertical%3Acompany%2Cidx%3A2-2-3%2CtarId%3A1432813095442%2Ctas%3Aqhse%20internatio" target="_blank"  style="color: #ffffff;">
														<img src="https://www.qhseinternational.com/wp-content/uploads/2020/03/in-new.jpg" alt="Twitter" width="30" height="30" style="display: block;" border="0" />
													</a>
												</td>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="https://www.youtube.com/channel/UCwBRvV88GxrdafUOtgK1alA?spfreload=10" target="_blank" style="color: #ffffff;">
														<img src="https://www.qhseinternational.com/wp-content/uploads/2020/03/youu-new.jpg" alt="Twitter" width="30" height="30" style="display: block;" border="0" />
													</a>
												</td>
                                                <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="https://api.whatsapp.com/send?phone=971553557473" target="_blank"  style="color: #ffffff;">
														<img src="https://www.qhseinternational.com/wp-content/uploads/2020/03/wha-new.jpg" alt="Twitter" width="30" height="30" style="display: block;" border="0" />
													</a>
												</td>
                             
												
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>';
return $template;
}
?>