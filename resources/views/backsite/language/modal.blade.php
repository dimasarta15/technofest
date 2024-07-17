<div class="modal modal-lang" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setting Localization</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@trans('backsite.language.fragment')</label>
                        <input type="text" disabled class="form-control txt-frag" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="@trans('backsite.language.fragment')">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">@trans('backsite.language.value')</label>
                        <input type="text" class="form-control txt-lang" placeholder="@trans('backsite.language.value')" value=""></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-modal-submit">@trans('backsite.language.save')</button>
                <button type="button" class="btn btn-secondary btn-modal-close" data-dismiss="modal">@trans('backsite.language.close')</button>
            </div>
        </div>
    </div>
</div>