# FOOD-ORDERING-WEBSITE

![](food_ordering_website.gif)



!!You will need to replace "APIKEY" with your own api key!!

----GENERAL----

index.php : The basic login menu.

register.php : Register a new User account to the database.

login.php : Login script with account check.

logout.php 

----USER----

![](user_register_order.gif)

menu.php : List of the store's menu.(saves cart with a list of selected products and proceeds to location.php if user is logged in)

location.php : Menu with 
                          a map to select the location of the place you want your order to be delivered
                          textboxes for information like the floor you live and what the name on the bell is
                          and also the items you are about to order with the total cost.

order.php : Submits the order to the database while finding the nearest store the location that the user selected 
            as well as the closest available delivery to that store.

final.php : If everything was executed without any errors the user is redirected to final.php 
            with a message that his order is on the way.

----DELIVERY----

![](Delivery.gif)

delivery.php : Start/End menu for the shift of the delivery.

delivery_location.php : Delivery enters his location to the database so that the delivery selections can be made efficient.

delivery_final.php : Registers the beginning of the shift.

delivery_order.php : Menu where every delivery can watch the details of orders assigned to them. (needs to be done with ajax)

delivery_order_completed.php : Updates the order to delivered.

delivery_stats.php : Displays data based on the selected date as well as earnings. 

getstats.php : Returns a table with data for the specific delivery.

----MANAGER----

![](Manager.gif)

manager_starting_page.php : Menu that displays quantities left and can be increased/decreased. (ajax)

product_data.php : Returns table with the quantities.

add_supplies.php : Script that updates the supplies.

manager_orders.php : Menu that displays the current active orders of the specific store (active meaning not deliverd)  (ajax)

man_order.php : Returns table with the orders.

----SUPERVISOR----

![](supervisor.gif)

supervisor.php : Menu that can't be accessed from Users by mistake. ( link needs to be typed )

supervisor_login.php : Supervisor login because this module should not be accessed by others.

supervisor_logout.php 

supervisor_script.php : Script that prints an XML file with the salaries.
