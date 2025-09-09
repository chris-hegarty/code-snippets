

Hi there,

I am a technical account manager that is leaning in to help while Allie is out of office.

The log sizes you're seeing are indeed normal, and I would actually like to highlight that there is a lot of great information about our access and error logs within our Support articles on logs. If there were an attack we'd be seeing a few of our security protocols jump into action and begin blocking a large number of requests with the 403 status code.

Many times, the kinds of traffic from bots don't adhere to any logical form of page requests, rather they crawl the site and hit pages that they can find in either the site's index.
The following analytics anomalies are the hallmarks of bot traffic:

Abnormally high pageviews: If a site undergoes a sudden, unprecedented and unexpected spike in pageviews, it’s likely that there are bots clicking through the site.
Abnormally high bounce rate: The bounce rate identifies the number of users that come to a single page on a site and then leave the site before clicking anything on the page. An unexpected lift in the bounce rate can be the result of bots being directed at a single page.
Surprisingly high or low session duration: Session duration, or the amount of time users stay on a website, should remain relatively steady. An unexplained increase in session duration could be an indication of bots browsing the site at an unusually slow rate. Conversely, an unexpected drop in session duration could be the result of bots that are clicking through pages on the site much faster than a human user would.
Junk conversions: A surge in phony-looking conversions, such as account creations using gibberish email addresses or contact forms submitted with fake names and phone numbers, can be the result of form-filling bots or spam bots.
Spike in traffic from an unexpected location: A sudden spike in users from one particular region, particularly a region that’s unlikely to have a large number of people who are fluent in the native language of the site, can be an indication of bot traffic.

An integrated web analytics tool, such as Google Analytics or Heap, can also help to detect bot traffic.

I went ahead and just double checked on last week's bot activity. I did see the reference to UA's with Chrome version 87, they totaled 2906 over the last 7 days. So while that is relatively low to the others, its still high for this outdated version of Chrome.

Here is the top user agents hitting the site this week:

Screenshot 2024-03-22 at 1.39.17 PM.png
It may also be good to look into setting up crawl delays for Google bot and Bingbot. We of course don't want to outright block these for SEO purposes, but you can set up rate limits to reduce the amount of concurrent requests from these known bots. More guidance on that can be found here

If you're wanting to take action on blocking certain User Agents using outdated browser versions there are certain measures that could be used to address these. If you're wanting a more hands-on approach that is self-serve we have our Web Rules Engine within the User Portal. There are a few examples in the guide of the kinds of rules that could be created to go after specific bots you're seeing that appear to be malicious. But it'd be good to have the specifics around such bot activity.

The other option is putting an access rule directly in the Nginx config file that would target bots using outdated browser versions. This one is not self-serve for customers, and either Technical Support, myself, or Allie would need to assist with getting this in place.

This rule is an example of such a rule:

Blocking outdated UAs
before-in-location
if ($http_user_agent ~* "Chrome/1|Chrome/2|Chrome/3|Chrome/4[0,2-8]|Chrome/5|Chrome/6|Chrome/7|Firefox/1|Firefox/2|Firefox/3|Firefox/4|Firefox/5|Mozilla/4|MSIE" ) {
return 444;
}

This rule is a bit outdated, so I may say if you want to go this route we should do some testing before adding it to production.

Let me know your thoughts here or if you have any additional questions!

Thanks,

---------- Forwarded message ---------
From: Chris.Hegarty <Chris.Hegarty@brand.com>
Date: Thu, Mar 21, 2024 at 6:27 PM
Subject: Possible unusual activity on brand.com
To: Brad.Wedeking <Brad.Wedeking@brand.com>, betsy.rivas@wpengine.com <betsy.rivas@wpengine.com>

Brad, Betsy, I was looking into an issue today on brand.com, and spotted what seemed like some unusual activity in our site logs. I reached out to WP Engine support reps, and I'm probably being overly concerned, but wanted to pass along a few details just to be on the safe side.

(Betsy, I'm looping you in here because Brad is out this week, so let me know if you think I should reach out to anyone else at WP Engine.)

My first concern was the volume of access logs, but the reps said it's not an unusual amount of activity for a large site like ours, and not amount that would indicate an attack on our servers.

My next concern was/is what some of the requests were targeting, for example, there were some requests for a root-level .env file, a bunch of requests for a csb.css file in the root directory (that doesn't exist there), and a lot of random cron requests. (The log is attached.).

The support rep I talked with over the phone said he did spot a pattern of requests coming from a Chrome 87 browser. He said it was unusual because it's so old, and could indicate malicious activity, but wasn't sure. (He said to maybe consider a rule blocking Chrome browsers before 90.)

Hopefully this all amounts to nothing out of the ordinary, but I know we are working to make our sites as secure as possible and I didn't want to overlook  potential red flags. Please let me know if I can provide any other information or take any further steps if needed...thanks very much.