<div class="row responsive-row">
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.one url="#" variant="primary" title="Total Agent" :value="128"
            icon="las la-agent" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.one url="#" variant="success" title="Active Agent" :value="95"
            icon="las la-user-check" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.one url="#" variant="warning" title="Email Unverified Agent" :value="18"
            icon="lar la-envelope" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.one url="#" variant="danger" title="Mobile Unverified Agent" :value="15"
            icon="las la-comment-slash" />
    </div>
</div>