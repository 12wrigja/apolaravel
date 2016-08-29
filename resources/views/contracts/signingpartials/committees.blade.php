<h4>Committees: </h4>

<p>Please rank the following committees from most to least preferred. They will move
    around as
    you rate
    them, and the order in which they are on the screen (from top to bottom, most to
    least
    preferred) is the order that
    will be submitted.</p>
<table class="table table-responsive">
    <thead>
    <th>Committee</th>
    <th>Rating</th>
    </thead>
    <tr v-repeat="committee in form.committees | orderBy 'rating'">
        <td>
            @{{ committee.name }}
        </td>
        <td>
            <div class="btn btn-success" v-on="click: decreaseRating(committee)">
                Higher
            </div>
            <div class="btn btn-danger" v-on="click: increaseRating(committee)">
                Lower
            </div>
        </td>
    </tr>
</table>