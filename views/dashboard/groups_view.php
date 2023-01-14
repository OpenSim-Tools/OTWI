
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">

        <!--Start Dashboard Content-->
        <?php foreach ($this->os_groups as $value) { ?>
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">group profile - <?php echo $value['Name']; ?></div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush table-borderless">
                                <tr>
                                    <td>Group-UUID:</td>
                                    <td colspan="2"><?php echo $value['GroupID']; ?></td>
                                </tr>
                                <tr>
                                    <td>Founder:</td>
                                    <td colspan="2"><?php echo $this->findUser->os_findUser($value['FounderID']); ?></td>
                                </tr>
                                <tr>
                                    <td>### Pictures ###</td>
                                    <td colspan="2"><textarea rows="5" cols="40" disabled><?php echo $value['Charter']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Member</td>
                                    <td class="text-center">Title</td>
                                    <td class="text-right">Status</td>
                                </tr>
                                <?php foreach($this->membership as $member) { ?>
                                
                                <tr>
                                    <td><?php echo $this->findUser->os_findUser($member['PrincipalID']); ?></td>
                                    <td class="text-center"><?php echo $member['Title']; ?></td>
                                    <td class="text-right"><?php echo $member['Name']; ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td class="text-center">
                                        <table class="table align-items-center table-flush table-borderless">
                                            <tr>
                                                <td>personal settings</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" disabled <?php if ($value['ListInProfile'] == 1) { echo 'checked'; } ?>> Show on my profile</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" disabled <?php if ($value['AcceptNotices'] == 1) { echo 'checked'; } ?>> receive group notifications</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" disabled <?php if ($value['AcceptNotices'] == 1) { echo 'checked'; } ?>> Join the group chat</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select size="1">
                                                        <option <?php if($value['MaturePublish'] == 1) { echo 'selected'; } ?>>Owners</option>
                                                        <option <?php if($value['MaturePublish'] == 0) { echo 'selected'; } ?>>Everyone</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td>&nbsp;</td>

                                    <td class="text-center">
                                        <table class="table align-items-center table-flush table-borderless">
                                            <tr>
                                                <td>group settings</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" disabled <?php if ($value['ShowInList'] == 1) { echo 'checked'; } ?>> Show in search</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" disabled <?php if ($value['OpenEnrollment'] == 1) { echo 'checked'; } ?>> anyone can join</td>
                                            </tr>
                                            <tr>
                                                <td>cost of joining: <strong><?php echo $value['MembershipFee']; ?></strong>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select size="1">
                                                        <option <?php if($value['MaturePublish'] == 1) { echo 'selected'; } ?>>moderate content</option>
                                                        <option <?php if($value['MaturePublish'] == 0) { echo 'selected'; } ?>>General Content</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>                                        
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
         
        <?php } ?>
        <!--End Dashboard Content-->

    </div>
    <!-- End container-fluid-->

</div><!--End content-wrapper-->


</div><!--End content-wrapper-->
<!--Start Back To Top Button-->
<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
<!--End Back To Top Button-->

<!--Start footer-->
<footer class="footer">
    <div class="container">
        <div class="text-center">
            Copyright 2023 by OpenSim Tools. Alle Rechte vorbehalten. <?php echo $this->version; ?>
        </div>
    </div>
</footer>
<!--End footer-->