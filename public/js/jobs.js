(async function () {
  var jobsJson = await fetchJobsJson('https://feed.midlandjobs.ie/demo/');
  var jobsQ = JsonQuery(jobsJson); //Initialize the Query Engine
  var kilbegganJobs = jobsQ.where({'company': 'Kilbeggan Community Group'}).exec();
  const MyJobsObject = new JobBoardFilteredFeed(42, kilbegganJobs, {

    pagination: {
      visiblePages: 3, // set init visible pages within the pagination
      initPerPage: 3, // set an initial per page count (in case where perPage below is false/not set)
      perPage: {
        values: [3, 5] // per page dropdown options
      },
    },

    filters: [
      {
        key: 'city',
        singular: 'Town/City',
        plural: 'Cities',
        type: 'option',
        setArray: false,
        removeTerms: []
      },
      {
        key: 'category',
        singular: 'Category',
        plural: 'Categories',
        type: 'checkbox',
        setArray: true,
        removeTerms: []
      }
    ],

  });
  MyJobsObject.renderTheJobs('#MyJobs');
})();