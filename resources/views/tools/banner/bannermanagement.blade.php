@extends('templates.crud_template')

@section('crud_form')
    <banner-manager inline-template>
        <h1>The APO Banner Management Tool</h1>

        <p>This tool allows the user to edit the front page banner by modifying the existing slides or creating new
            ones.</p>

        <div class="btn btn-primary btn-success" v-on="click: createSlide()">Create Slide</div>
        <div class="tab-pane fade in active">
            <div v-show="slides | empty">
                <h4>There is nothing in the banner right now! This should never have happened</h4>
            </div>
            <div v-repeat="slide : slides">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading@{{slide.id}}">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse@{{slide.id}}" aria-expanded="false"
                               aria-controls="collapse@{{slide.id}}">
                                @{{slide.title}} |
                                @{{slide.caption}}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse@{{slide.id}}" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="heading@{{slide.id}}">
                        <div class="panel-body">
                            <div class="well">
                                <div class="btn btn-primary" v-on="click: editSlide(slide)">Edit</div>
                                <div class="btn btn-success" v-class="disabled: slide.isEnabled" v-on="click: enableSlide(slide)">Enable</div>
                                <div class="btn btn-danger" v-class="disabled: slide.isEnabled" v-on="click: disableSlide(slide)">Disable</div>
                            </div>
                            <p>Action Text: @{{slide.action_text}}</p>
                            <p>Action URL: @{{ slide.action_url }}</p>
                            <p>Image: </p>
                            <img class="img-thumbnail img-responsive" v-attr="src: slide.background_image.href">
                        </div>
                    </div>
                </div>
            </div>
            <nav v-show="showReportPagination">
                <ul class="pager">
                    <li class="previous" v-show="showReportPagination && reports.meta.pagination.links.next"><a
                                class="btn" v-on="click: getPage(reports_page+1,false)"><span
                                    aria-hidden="true">&larr;</span> Older</a></li>
                    <li class="next" v-show="showReportPagination && reports.meta.pagination.links.previous"><a
                                class="btn" v-on="click: getPage(reports_page-1,false)">Newer <span
                                    aria-hidden="true">&rarr;</span></a></li>
                </ul>
            </nav>
        </div>
        <form_editor v-ref="editForm" can-submit="canSubmit" item-name="Carousel Item">
            @include('tools.banner.carouselitemform')
        </form_editor>
    </banner-manager>
@endsection