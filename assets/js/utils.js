export default {
    getCurrentWeek() {
        let today = new Date 
        let week = []
        var weekday = [
            "",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday",
        ]

        for (let i = 1; i <= 7; i++) {
            let first = today.getDate() - today.getDay() + i
            var day = {'date': new Date(today.setDate(first)).toLocaleDateString('fr-FR').slice(0, 10), 'weekday': weekday[i]}
            week.push(day)
        }
        return week;
    }
}
