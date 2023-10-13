# Problem
Handling webhooks from a partner that requires the response as fast as possible, empty and under 2s. 
Anything over 2s would be considered a failure by the partner, 
leading to extra manual work to ensure data will not be lost and broken in our system.

Use Stripe as an example for posted webhooks, as they pass multiple post requests,
each having separate critical data that might have something critical in common between themselves.

The result must be able to have in the database all data, with expected linked parents.

We want to see an implementation with Laravel, but feel free to do it with another framework/platform.

Don’t forget: Stripe expects a webhook’s response to be <2s and a possible transaction might have data 
spread over multiple requests that will not come in the ideal order.

Note: we are not interested in 100% full implementation, so do not spend time on perfect data normalisation or similar. 
You may even skip most of the data irrelevant to the test.

# Solution proposed
Taking inspiration from the first interview discussion, I'll be using a queue system to register the webhooks
and process them asynchronously on different queues.
Later the worker will process the data from the queue and store it in the database.

To speed things up I'll be using Redis as the job queue store and mysql as the database for the data. 

I'll reduce my focus on the datastore and store data which is not relevant to the task as simple json strings for 
this mvc while still having the chance to build a proper data model in the future without data loss.

I'll be using Laravel as the framework for this mvc.

I'll be using pest to test the app and ensure that the response is sent back to the client in under 2 seconds (ideally less than one).

We'll not be checking the Http signature of the request as it's not relevant to the task but it should be implemented in production. 
See https://stripe.com/docs/webhooks#verify-official-libraries

Similarly, will be ignoring the reply attack at the moment so it needs to be done before going in production. 
See https://stripe.com/docs/webhooks#replay-attacks

Because of the above limitations I'll probably use this plugin to streamline 
my development https://github.com/spatie/laravel-stripe-webhooks and produce better code.
Unfortunately, I discovered it latter while developing the mvc. 
