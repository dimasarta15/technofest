<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Export</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="row">
                                <label class="col-sm-2 label-on-left"><small>Status</small></label>
                                <div class="col-sm-10">
                                    <label class="control-label"></label>
                                    <div class="form-group label-floating is-empty">
                                        <select class="form-control" name="status_export" id="sel_export_status">
                                            <option value="" disabled selected> Choose One </option>
                                            <option value="1">Active</option>
                                            <option value="0">Non-Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="btn_export" type="button">Export</button>
            </div>
        </div>
    </div>
</div>