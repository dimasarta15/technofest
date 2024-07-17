<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Options</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="row">
                                <table class="form-table" style="width: 100%" id="customFields">
                                    <tr valign="top">
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control option_label" name="option_label[]" value="" placeholder="Option Label" /> &nbsp;
                                                <input type="text" class="form-control option_value" name="option_value[]" value="" placeholder="Option Value" /> &nbsp;
                                                <a href="javascript:void(0);" class="remCF btn btn-danger btn-sm mt-1">Remove</a>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="col-12 d-flex justify-content-between">
                                    <a href="javascript:void(0);" class="addCF btn btn-primary btn-sm mt-2">Add</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="btn_export" type="button">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="popup-copas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label class="col-sm-2 label-on-left"><small>Quizioner Source</small></label>
                                <div class="col-sm-10">
                                    <label class="control-label"></label>
                                    <div class="form-group label-floating is-empty">
                                        <select class="form-control" name="source" id="sel_source">
                                            <option value="" disabled selected> Choose One </option>
                                            @forelse ($semesters as $sm)
                                                <option value="{{ $sm->id }}">{{ $sm->title }} - {{ $sm->semester }}</option>
                                            @empty
                                            @endforelse
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
                <button class="btn btn-primary" id="btn_paste" type="button">Paste</button>
            </div>
        </div>
    </div>
</div>