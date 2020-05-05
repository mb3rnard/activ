<script>
    import axios from 'axios'
	import utils from '../utils'
	import ActivityRecord from "./ActivityRecord";

    export default {
        name: "calendar",
		components: {ActivityRecord},
        data() {
            return {
                activities: [],
				recordedActivities: []
            };
		},
		methods: {
			week() {
				return utils.getCurrentWeek();
			}
		},
        async created() {
			axios.get("/activities").then(response => {this.activities = response.data})
			await axios.get("/recorded-activities/04-05-2020/11-05-2020").then(response => {this.recordedActivities = response.data})
        }
   }
</script>

<template>
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100 ver1">
					<div class="table100-firstcol">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">Activity</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="activity in activities" :key="activity.name" class="row100 body">
									<td class="cell100 column1">{{ activity.name }}</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="wrap-table100-nextcols js-pscroll">
						<div class="table100-nextcols">
							<table>
								<thead>
									<tr class="row100 head">
										<th v-for="day in week()" :key="day.weekday" class="cell100 column2">{{ day.weekday }} {{ day.date }}</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="activity in activities" class="row100 body">
										<td v-for="(recordedActivity, date) in recordedActivities" class="cell100 column2">
											<ActivityRecord :date="date" :activity="activity.id" :recorded="recordedActivities[date][activity.name]">
											</ActivityRecord>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
