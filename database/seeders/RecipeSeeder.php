<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Libraries\ImageLibrary;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Recipe::factory()->create();

        $recipes = [
            [
                'user_id' => 1,
                'title' => 'Homemade Sushi',
                'summary' => 'Sushi rolls can be filled with any ingredients you choose. Try smoked salmon instead of imitation crabmeat. Serve with teriyaki sauce and wasabi.',
                'ingredients' => '[{"item":"1 ⅓ cups water"},{"item":"⅔ cup uncooked short-grain white rice"},{"item":"3 tablespoons rice vinegar"},{"item":"3 tablespoons white sugar"},{"item":"1 ½ teaspoons salt"},{"item":"4 sheets nori seaweed sheets"},{"item":"½ pound imitation crabmeat, flaked"},{"item":"1 avocado - peeled, pitted, and sliced"},{"item":"½ cucumber, peeled, cut into small strips"},{"item":"2 tablespoons pickled ginger"}]',
                'instruction' => '[{"instruction_item":"Gather all ingredients. Preheat the oven to 300 degrees F (150 degrees C).","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_E0Ksaxew9M.webp"},{"instruction_item":"Bring water to a boil in a medium pot; stir in rice. Reduce heat to medium-low, cover, and simmer until rice is tender and water has been absorbed, 20 to 25 minutes.","attached_photo":""},{"instruction_item":"Mix rice vinegar, sugar, and salt in a small bowl. Gently stir into cooked rice in the pot and set aside.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_X6DUi4Qqig.webp"},{"instruction_item":"Lay nori sheets on a baking sheet.\n\n","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_9xqGHPkEyJ.webp"},{"instruction_item":"Heat nori in the preheated oven until warm, 1 to 2 minutes.","attached_photo":""},{"instruction_item":"Center 1 nori sheet on a bamboo sushi mat. Use wet hands to spread a thin layer of rice on top. Arrange 1\/4 of the crabmeat, avocado, cucumber, and pickled ginger over rice in a line down the center.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_fNfoKO7LUT.webp"},{"instruction_item":"Lift one end of the mat and roll it tightly over filling to make a complete roll. Repeat with remaining ingredients.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_Wqx9GZxRrh.webp"},{"instruction_item":"Use a wet, sharp knife to cut each roll into 4 to 6 slices.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_E4Abpp3ybd.webp"}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_1/banner/240207_1707309499_ltGsBTrqWl.webp',
                'thumbnail' => 'uploads/recipes/user_1/thumbnail/240207_1707309499_md3jtjla7d.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 2,
                'title' => 'Garlic Parmesan Chicken Wings',
                'summary' => 'Keep these baked garlic parmesan chicken wings crispy by parboiling the wings in a flavorful liquid, which helps season the chicken and produce a surface texture in the oven that your guests will swear came straight out of a deep fryer. Serve with creamy Italian dressing for dipping.',
                'ingredients' => '[{"item":"cooking spray"},{"item":"3 quarts cold water"},{"item":"⅓ cup balsamic vinegar"},{"item":"¼ cup salt"},{"item":"1 bay leaf"},{"item":"1 teaspoon dried thyme"},{"item":"1 teaspoon dried oregano"},{"item":"1 teaspoon dried rosemary"},{"item":"8 cloves garlic, minced"},{"item":"1 pinch salt"},{"item":"3 tablespoons olive oil, or as needed"},{"item":"1 tablespoon freshly ground black pepper"},{"item":"2 teaspoons red pepper flakes, or to taste"},{"item":"4 pounds chicken wings, separated at joints, tips discarded"},{"item":"2 tablespoons fine bread crumbs"},{"item":"1 cup finely grated Parmigiano-Reggiano cheese, divided"}]',
                'instruction' => '[{"instruction_item":"Preheat an oven to 450 degrees F (230 degrees C). Line a baking sheet with aluminum foil and coat foil with cooking spray.","attached_photo":""},{"instruction_item":"Combine water, vinegar, 1\/4 cup salt, bay leaf, thyme, oregano, and rosemary in a large stockpot and bring to a boil. Add chicken wings, return to a boil, and cook for 15 minutes. Remove chicken wings with a slotted spoon to a cooling rack and allow to dry for 15 minutes.","attached_photo":"uploads\/recipes\/user_2\/instruction\/240207_1707311000_LjIMH7Rmgh.webp"},{"instruction_item":"Mash garlic and a pinch of salt together in a mortar and pestle until smooth.","attached_photo":"uploads\/recipes\/user_2\/instruction\/240207_1707311000_Qlgpluht1C.webp"},{"instruction_item":"Combine mashed garlic, olive oil, black pepper, and red pepper flakes in a large bowl.","attached_photo":"uploads\/recipes\/user_2\/instruction\/240207_1707311000_1xR4EtFhl5.webp"},{"instruction_item":"Add chicken wings and bread crumbs; toss to coat. Sprinkle with 1\/2 cup Parmigiano-Reggiano cheese.\n\n","attached_photo":"uploads\/recipes\/user_2\/instruction\/240207_1707311257_yCx1OmzfaZ.webp"},{"instruction_item":"Transfer to the prepared baking sheet and sprinkle with remaining 1\/2 cup Parmigiano-Reggiano cheese.","attached_photo":"uploads\/recipes\/user_2\/instruction\/240207_1707311257_ryflsrK5Wr.webp"},{"instruction_item":"Bake in the preheated oven until browned, 20 to 25 minutes.","attached_photo":"uploads\/recipes\/user_2\/instruction\/240207_1707311257_3ms3rtBs2D.webp"},{"instruction_item":"Serve hot and enjoy!","attached_photo":"uploads\/recipes\/user_2\/instruction\/240207_1707311257_RWVTz62i8d.webp"}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_2/banner/240207_1707311000_HaWVkj0GlO.webp',
                'thumbnail' => 'uploads/recipes/user_2/thumbnail/240207_1707311000_W763dKPMqH.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 3,
                'title' => 'Garlic-Ginger Chicken Wings',
                'summary' => "My mom lives in a small town in western New York, called Clifton Springs. Whenever I go home to visit, I usually indulge in some Buffalo chicken wings from a place called Emerson's. They have two flavors of wings; Buffalo-style, and sweet and sour. I came up with what turned out to be a deliciously sticky, ginger and garlic glaze. I really hope you give these a try.",
                'ingredients' => '[{"item":"cooking spray"},{"item":"5 pounds chicken wings, separated at joints, tips discarded"},{"item":"salt and ground black pepper to taste"},{"item":"3 tablespoons hot sauce (such as Frank\'s Red Hot ®)"},{"item":"2 tablespoons vegetable oil"},{"item":"1 cup all-purpose flour"},{"item":"For the glaze:"},{"item":"3 crushed garlic cloves"},{"item":"2 tablespoons minced fresh ginger root"},{"item":"1 tablespoon Asian chile pepper sauce"},{"item":"½ cup rice vinegar"},{"item":"½ cup packed brown sugar"},{"item":"1 tablespoon soy sauce"}]',
                'instruction' => '[{"instruction_item":"Preheat oven to 400 degrees F (200 degrees C). Line 2 baking sheets with aluminum foil; grease the foil with cooking spray.","attached_photo":""},{"instruction_item":"Place the chicken in a large mixing bowl. Season with salt, pepper, and hot sauce. Add the vegetable oil; toss to coat.","attached_photo":""},{"instruction_item":"Place the flour and wings in a large, food-safe plastic bag. Hold the bag closed tightly, and shake to coat the wings entirely with the flour; no wet spots should remain. Arrange the wings on the prepared baking sheets, making sure none of the pieces are touching one another. Spray wings with additional cooking spray","attached_photo":""},{"instruction_item":"Bake in the preheated oven for 30 minutes, turn all the wings, and return to the oven to cook until crispy and no longer pink in the center, about 30 minutes more.","attached_photo":""},{"instruction_item":"Whisk together the garlic, ginger, chili paste, rice vinegar, brown sugar, and soy sauce in a saucepan. Bring the mixture to a boil and immediately remove from heat.","attached_photo":""},{"instruction_item":"Put about half the wings in a large mixing bowl. Pour about half the sauce over the wings. Toss the wings with tongs to coat evenly; transfer to a tray and allow to sit about 5 minutes to allow the sauce to soak into the wings before serving. Repeat with remaining wings and sauce.","attached_photo":"uploads\/recipes\/user_3\/instruction\/240207_1707312555_MrL1FahXoW.webp"}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_3/banner/240207_1707312555_EpRcQgRQgt.webp',
                'thumbnail' => 'uploads/recipes/user_3/thumbnail/240207_1707312555_jMp0bo5UyL.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 4,
                'title' => 'Traditional Filipino Lumpia',
                'summary' => 'This is a traditional Filipino recipe for lumpia, or fried spring rolls. They&#039;re made with paper-thin lumpia wrappers and filled with a savory mixture of ground pork, cabbage, and other vegetables. Serve lumpia as a side dish or appetizer with a sweet chili dipping sauce.',
                'ingredients' => '[{"item":"1 tablespoon vegetable oil"},{"item":"1 pound ground pork"},{"item":"½ cup chopped onion"},{"item":"2 cloves garlic, crushed"},{"item":"½ cup minced carrots"},{"item":"½ cup chopped green onions"},{"item":"½ cup thinly sliced green cabbage"},{"item":"2 tablespoons chopped fresh cilantro (Optional)"},{"item":"1 teaspoon ground black pepper"},{"item":"1 teaspoon salt"},{"item":"1 teaspoon garlic powder"},{"item":"1 teaspoon soy sauce"},{"item":"30 lumpia wrappers"},{"item":"2 cups vegetable oil for frying, or as needed"}]',
                'instruction' => '[{"instruction_item":"Heat 1 tablespoon vegetable oil in a wok or large skillet over high heat. Add pork; cook and stir until crumbly and no pink is showing, 5 to 7 minutes. Remove pork from the pan and set aside. Drain grease from the pan, leaving just a thin coating.","attached_photo":""},{"instruction_item":"Add onion and garlic to the pan; cook and stir until fragrant, about 2 minutes. Stir in the cooked pork, carrots, green onions, cabbage, and cilantro. Season with pepper, salt, garlic powder, and soy sauce. Remove from the heat, and set aside until cool enough to handle, about 5 minutes.","attached_photo":""},{"instruction_item":"Assemble lumpia: Place 3 heaping tablespoons of filling diagonally near one corner of a lumpia wrapper, leaving a 1 1\/2 inch space at both ends. Fold the side along the length of the filling over the filling, tuck in both ends, and roll neatly and tightly to close. Moisten the other side of the wrapper with water to seal the edge. Transfer to a plate and cover with plastic wrap to retain moisture. Repeat to assemble remaining lumpia.","attached_photo":""},{"instruction_item":"Heat 1\/2 inch vegetable oil in a heavy skillet over medium heat for 5 minutes.","attached_photo":""},{"instruction_item":"Slide 3 to 4 lumpia into the hot oil, making sure the seams are facing down. Fry, turning occasionally, until all sides are golden brown, 1 to 2 minutes. Transfer to a paper towel-lined plate to drain. Repeat to fry remaining lumpia. Serve immediately.","attached_photo":"uploads\/recipes\/user_4\/instruction\/240208_1707355285_HeECdOcg1Y.webp"}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_4/banner/240208_1707355251_fGaYw6FXEl.webp',
                'thumbnail' => 'uploads/recipes/user_4/thumbnail/240208_1707355251_ie2iReCnNz.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 5,
                'title' => 'Tilapia with Lemon-Boursin Cream Sauce',
                'summary' => "For this tilapia with lemon-Boursin cream sauce, fish filets are pan-fried until golden, then topped with a quick, creamy lemon pan sauce made with Boursin cheese, fresh lemon juice, and cream. It comes together so quickly, but tastes as if you've spent an hour cooking.",
                'ingredients' => '[{"item":"Tilapia:"},{"item":"1 tablespoon olive oil"},{"item":"1 tablespoon butter"},{"item":"1 pound tilapia filets"},{"item":"1 teaspoon salt"},{"item":"1/2 teaspoon freshly ground black pepper"},{"item":"1 teaspoon italian seasoning"},{"item":"Boursin Sauce:"},{"item":"1 tablespoon butter"},{"item":"2 cloves garlic, minced"},{"item":"1/2 cup vegetable broth"},{"item":"1/4 cup heavy cream"},{"item":"1 ounce soft French cheese (such as Boursin® Garlic & Fine Herbs Cheese)"},{"item":"1 1/2 tablespoons freshly squeezed lemon juice"},{"item":"1 lemon, sliced, for garnish"}]',
                'instruction' => '[{"instruction_item":"Heat olive oil with 1 tablespoon butter in a skillet over medium heat until butter is melted.","attached_photo":""},{"instruction_item":"Season fish on both sides with salt, pepper, and Italian seasoning. Add fish to the skillet and cook until a golden crust appears, about 3 minutes per side. Remove fish from the skillet and set aside; keep warm.","attached_photo":""},{"instruction_item":"Melt remaining 1 tablespoon butter in the same skillet over medium-high heat; add garlic and cook until fragrant, about 1 minute.","attached_photo":""},{"instruction_item":"Pour in vegetable broth; cook for 4 minutes. Reduce heat to medium-low and slowly whisk in heavy cream and Boursin cheese. Add lemon juice and whisk constantly until the sauce is well combined and smooth. Season to taste with salt and pepper.","attached_photo":""},{"instruction_item":"Place fish on serving plates, and pour the sauce over. Garnish with fresh lemon slices.","attached_photo":""}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_5/banner/240208_1707355576_hPSeLMUywJ.webp',
                'thumbnail' => 'uploads/recipes/user_5/thumbnail/240208_1707355576_vpsPpMMFwA.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 6,
                'title' => 'Pan-Seared Lemon Tilapia with Parmesan Pasta',
                'summary' => 'This fish pasta recipe features citrusy tilapia served with a light, cheesy pasta.',
                'ingredients' => '[{"item":"Pasta:"},{"item":"4 ounces elbow macaroni"},{"item":"1 tablespoon light olive oil"},{"item":"¼ cup freshly grated Parmesan cheese"},{"item":"1 teaspoon lemon juice"},{"item":"1 pinch garlic powder"},{"item":"1 pinch dried basil"},{"item":"1 pinch dried oregano"},{"item":"1 pinch dried cilantro (Optional)"},{"item":"salt and ground black pepper to taste"},{"item":"Fish:"},{"item":"2 tablespoons light olive oil"},{"item":"2 tilapia fillets"},{"item":"1 tablespoon lemon juice"},{"item":"⅛ teaspoon dried oregano"},{"item":"1 pinch dried basil"},{"item":"1 pinch dried cilantro (Optional)"},{"item":"salt and ground black pepper to taste"}]',
                'instruction' => '[{"instruction_item":"Start the pasta: Bring a saucepan of lightly salted water to a boil over medium heat. Stir in macaroni and return to a boil. Cook, stirring occasionally, until tender yet firm to the bite, about 8 minutes.","attached_photo":""},{"instruction_item":"While the pasta is cooking, make the fish: Heat olive oil in a large skillet over medium heat. Sprinkle tilapia on both sides with lemon juice, oregano, basil, cilantro, salt, and pepper. Place fillets into the hot skillet making sure they don\'t touch. Sear until golden brown on the outside and opaque and flaky on the inside, 2 to 4 minutes per side. Remove to a plate.","attached_photo":""},{"instruction_item":"Finish the pasta: Drain the macaroni and return to the saucepan. Add olive oil and stir to coat. Mix in Parmesan cheese, then mix in lemon juice, garlic powder, basil, oregano, cilantro, salt, and pepper.","attached_photo":""},{"instruction_item":"Divide pasta between two plates and top each with a tilapia fillet.","attached_photo":""}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_6/banner/240208_1707355802_sxXtJbA99S.webp',
                'thumbnail' => 'uploads/recipes/user_6/thumbnail/240208_1707355802_UyunPCLx0X.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 7,
                'title' => 'Vietnamese Fresh Spring Rolls',
                'summary' => 'These Vietnamese spring rolls are a refreshing change from the usual fried variety and have become a family favorite. They are a great summertime appetizer and delicious dipped in one or both of the sauces.',
                'ingredients' => '[{"item":"2 ounces rice vermicelli"},{"item":"8 rice wrappers (8.5 inch diameter)"},{"item":"8 large cooked shrimp - peeled, deveined and cut in half"},{"item":"2 leaves lettuce, chopped"},{"item":"3 tablespoons chopped fresh mint leaves"},{"item":"3 tablespoons chopped fresh cilantro"},{"item":"1 ⅓ tablespoons chopped fresh Thai basil"},{"item":"Sauces:"},{"item":"¼ cup water"},{"item":"2 tablespoons fresh lime juice"},{"item":"2 tablespoons white sugar"},{"item":"4 teaspoons fish sauce"},{"item":"1 clove garlic, minced"},{"item":"½ teaspoon garlic chili sauce"},{"item":"3 tablespoons hoisin sauce"},{"item":"1 teaspoon finely chopped peanuts"}]',
                'instruction' => '[{"instruction_item":"Fill a large pot with lightly salted water and bring to a rolling boil; stir in vermicelli pasta and return to a boil. Cook pasta uncovered, stirring occasionally, until the pasta is tender yet firm to the bite, 3 to 5 minutes.","attached_photo":""},{"instruction_item":"Fill a large bowl with warm water. Dip one wrapper into the hot water for 1 second to soften. Lay wrapper flat; place 2 shrimp halves in a row across the center, add some vermicelli, lettuce, mint, cilantro, and basil, leaving about 2 inches uncovered on each side. Fold uncovered sides inward, then tightly roll the wrapper, beginning at the end with lettuce. Repeat with remaining ingredients.","attached_photo":""},{"instruction_item":"For the sauces: Mix water, lime juice, sugar, fish sauce, garlic, and chili sauce in a small bowl until well combined. Mix hoisin sauce and peanuts in a separate small bowl.","attached_photo":""}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_7/banner/240208_1707356936_qHvZ73jd5x.webp',
                'thumbnail' => 'uploads/recipes/user_7/thumbnail/240208_1707356936_nhx9gaRHNu.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 8,
                'title' => 'Bang Bang Potatoes',
                'summary' => 'Super crispy oven-roasted potatoes drizzled with a sweet and spicy creamy sauce—need we say more?',
                'ingredients' => '[{"item":"1 1/2 lb. baby gold potatoes, peeled and halved"},{"item":"2 tablespoons olive oil"},{"item":"1 tablespoon cornstarch"},{"item":"1 teaspoon kosher salt"},{"item":"1/2 teaspoon onion powder"},{"item":"1/2 teaspoon garlic powder"},{"item":"1/4 teaspoon paprika"},{"item":"1/2 cup mayonnaise"},{"item":"2 tablespoons whole buttermilk"},{"item":"2 tablespoons Sriracha chile sauce"},{"item":"1 tablespoon sweet Thai chili sauce"},{"item":"1 teaspoon rice vinegar"},{"item":"sliced scallions for garnish"}]',
                'instruction' => '[{"instruction_item":"Gather all ingredients.","attached_photo":"uploads\/recipes\/user_8\/instruction\/240208_1707386632_z8z32lNCrk.webp"},{"instruction_item":"Preheat the oven to 450 degrees F (230 degrees C).","attached_photo":""},{"instruction_item":"Toss together potatoes and olive oil on a large rimmed baking sheet until fully coated. Whisk together cornstarch, salt, onion powder, garlic powder, and paprika in a small bowl until combined. Sprinkle evenly over potatoes; toss to coat, arranging potatoes in an even layer.\n\n","attached_photo":"uploads\/recipes\/user_8\/instruction\/240208_1707386632_S0IWkIcjN3.webp"},{"instruction_item":"Bake in the preheated oven until deep golden brown and crispy on all sides, stirring every 10 minutes, 30 to 35 minutes. Remove from oven and let rest on baking sheet for 5 minutes before transferring to a serving dish.\n\n","attached_photo":""},{"instruction_item":"Meanwhile prepare the sauce; whisk together mayonnaise, buttermilk, Sriracha, sweet Thai chili sauce, and rice vinegar in a small bowl until fully combined. Drizzle sauce over potatoes; garnish with sliced scallions.","attached_photo":"uploads\/recipes\/user_8\/instruction\/240208_1707386632_JShPCHXjSt.webp"}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_8/banner/240208_1707386632_t1Hdgtif0r.webp',
                'thumbnail' => 'uploads/recipes/user_8/thumbnail/240208_1707386632_RN6KJiBIBK.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 9,
                'title' => 'Crispy Smashed Potatoes',
                'summary' => 'These smashed potatoes are twice-cooked to get that tender potato with crispy skin. These delicious morsels are infused with olive oil, butter, garlic, and herbs for incredible flavor. My family asks for them often!',
                'ingredients' => '[{"item":"1 ½ pounds small yellow-fleshed potatoes"},{"item":"¼ cup olive oil"},{"item":"2 tablespoons balsamic vinegar"},{"item":"1 teaspoon butter at room temperature"},{"item":"3 cloves garlic, minced"},{"item":"1 teaspoon dried rosemary"},{"item":"½ teaspoon dried sage"},{"item":"½ teaspoon ground thyme"},{"item":"½ teaspoon dried savory"},{"item":"½ teaspoon sea salt"},{"item":"½ teaspoon ground black pepper"}]',
                'instruction' => '[{"instruction_item":"Gather all ingredients.","attached_photo":"uploads\/recipes\/user_9\/instruction\/240208_1707386940_b8OyDkROSF.webp"},{"instruction_item":"Place potatoes in a saucepan; fill with enough water to cover potatoes. Bring to a boil; reduce heat to medium-low and cook potatoes until tender but not mushy, about 15 to 20 minutes. Drain potatoes in a colander; transfer to a baking sheet lined with a clean dish towel and allow to cool and dry out a little, about 10 minutes.","attached_photo":"uploads\/recipes\/user_9\/instruction\/240208_1707386940_c8pcIIS9Ti.webp"},{"instruction_item":"While potatoes are cooling, mix olive oil, balsamic vinegar, butter, garlic, rosemary, sage, thyme, savory, salt, and pepper in a bowl until well combined.","attached_photo":"uploads\/recipes\/user_9\/instruction\/240208_1707386940_kuGRD70hr5.webp"},{"instruction_item":"Preheat the oven to 450 degrees F (230 degrees C). Line a baking sheet with parchment paper.","attached_photo":""},{"instruction_item":"Place cooled potatoes in a single layer on the prepared baking sheet. Use a potato masher or the heel of your hand to lightly press down on potatoes to crush them.","attached_photo":"uploads\/recipes\/user_9\/instruction\/240208_1707386940_Ag4aKGmmcu.webp"},{"instruction_item":"Spoon the oil-herb mixture over each smashed potato.","attached_photo":"uploads\/recipes\/user_9\/instruction\/240208_1707386940_OSCr9vkRIE.webp"},{"instruction_item":"Bake potatoes in the preheated oven until crispy, about 25 minutes. Let cool slightly before serving.","attached_photo":"uploads\/recipes\/user_9\/instruction\/240208_1707386940_v01T4RsPah.webp"},{"instruction_item":"Enjoy!","attached_photo":"uploads\/recipes\/user_9\/instruction\/240208_1707386940_PsKUGLTO6t.webp"}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_9/banner/240208_1707386940_FFOkWnG2Vx.webp',
                'thumbnail' => 'uploads/recipes/user_9/thumbnail/240208_1707386940_m668Wzp8lk.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 10,
                'title' => 'Smash Burgers',
                'summary' => 'This smash burger recipe makes super juicy burgers with crispy edges. I prefer to cook these outdoors — they grill up very fast because of the high heat, so make sure you have everything ready to go!',
                'ingredients' => '[{"item":"4 hamburger buns"},{"item":"2 tablespoons butter, softened, or as needed"},{"item":"1 pound ground chuck beef (80% lean)"},{"item":"4 (6-inch) squares parchment paper"},{"item":"salt to taste"},{"item":"4 slices American cheese"},{"item":"burger toppings of choice"}]',
                'instruction' => '[{"instruction_item":"Preheat an outdoor grill for high heat and lightly oil the grate. Set a cast iron flat-top griddle or large cast iron skillet onto the grill and preheat until smoking.","attached_photo":""},{"instruction_item":"Spread butter on the inside of the buns and toast on the flat-top until lightly browned. Set aside.","attached_photo":""},{"instruction_item":"Form meat into 8 loosely-packed balls, 2 ounces each. Do not pack the meat tightly, as this will prevent it from smashing properly. Place each ball on the hot flat-top, cover with a piece of parchment (to prevent sticking to the spatula; re-use each parchment square on a second patty) and immediately smash down to a 1\/4 inch thickness using 2 stiff, sturdy spatulas that are criss-crossed to get proper leverage as you press down. You may also use the bottom of small skillet. Sprinkle the meat with salt.","attached_photo":""},{"instruction_item":"Grill for about 45 seconds, until the edges are dark brown and the centers are a light pink color. Using a bench scraper or firm spatula, gently scrape up the patties, flip over and immediately cover 4 of them with cheese. Grill an additional 15 to 20 seconds; stack the plain patties over the cheese-covered patties so you have 4 stacks. Move each stack to a bun and serve with your favorite toppings.","attached_photo":""}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_10/banner/240208_1707391910_rZtB1CU5HB.webp',
                'thumbnail' => 'uploads/recipes/user_10/thumbnail/240208_1707391910_CIvLZtLl4q.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 11,
                'title' => 'Pumpkin Coconut Bread',
                'summary' => 'This pumpkin coconut bread is a wonderful bread to serve during the fall holidays. The coconut makes it moist.',
                'ingredients' => '[{"item":"2 cups white sugar"},{"item":"1 cup packed brown sugar"},{"item":"1 cup vegetable oil or melted butter"},{"item":"4 eggs"},{"item":"1 (15 ounce) can pumpkin puree"},{"item":"3 ½ cups all-purpose flour"},{"item":"2 teaspoons baking soda"},{"item":"2 teaspoons salt"},{"item":"½ teaspoon ground cloves"},{"item":"1 ½ teaspoons ground cinnamon"},{"item":"1 teaspoon ground allspice"},{"item":"1 teaspoon ground nutmeg"},{"item":"1 cup flaked coconut"},{"item":"½ cup chopped walnuts"}]',
                'instruction' => '[{"instruction_item":"Preheat oven to 350 degrees F (175 degrees C). Grease and flour two 9 x 5 inch loaf pans.","attached_photo":""},{"instruction_item":"Mix together sugars, oil, and eggs. Mix in pumpkin. Add flour, salt, soda, and spices, and then water. Stir together until just moistened. Stir in coconut and nuts. Pour batter into prepared pans.","attached_photo":""},{"instruction_item":"Bake for 60 minutes, or until tester inserted in the center comes out clean.","attached_photo":""}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_11/banner/240208_1707392978_DTYZqTE5PU.webp',
                'thumbnail' => 'uploads/recipes/user_11/thumbnail/240208_1707392978_XB46wKgNX5.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 11,
                'title' => 'Banana Strawberry Muffins',
                'summary' => 'Healthier, fruity muffins… They\'re suitable for toddlers from 10 months on.',
                'ingredients' => '[{"item":"cooking spray"},{"item":"½ cup white sugar"},{"item":"¼ cup unsalted butter"},{"item":"2 small ripe bananas, mashed"},{"item":"1 egg"},{"item":"½ teaspoon vanilla extract"},{"item":"1 cup all-purpose flour"},{"item":"1 teaspoon baking powder"},{"item":"¼ teaspoon baking soda"},{"item":"¼ teaspoon salt (Optional)"},{"item":"5 small strawberries, chopped"}]',
                'instruction' => '[{"instruction_item":"Preheat the oven to 350 degrees F (175 degrees C). Grease 6 muffin cups with cooking spray.","attached_photo":""},{"instruction_item":"Combine sugar and butter in a medium bowl; beat with an electric mixer until pale and fluffy. Add bananas, egg, and vanilla extract; beat for 1 minute.","attached_photo":""},{"instruction_item":"Sift flour, baking powder, baking soda, and salt over the banana mixture. Beat until just combined. Stir in chopped strawberries. Pour batter into the prepared muffin cups.","attached_photo":""},{"instruction_item":"Bake in the preheated oven until a toothpick inserted into the center comes out clean, 16 to 18 minutes. Cool for 5 minutes then transfer to a wire rack to cool completely.","attached_photo":""}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_11/banner/240208_1707393338_gN7yWQeW8e.webp',
                'thumbnail' => 'uploads/recipes/user_11/thumbnail/240208_1707393338_NXFrOK98GZ.webp',
                'is_draft' => false
            ],
            [
                'user_id' => 11,
                'title' => 'Banana Oat Muffins',
                'summary' => 'An oatmeal banana muffin that\'s a healthy and delicious morning treat!',
                'ingredients' => '[{"item":"1 ½ cups unbleached all-purpose flour"},{"item":"1 cup rolled oats"},{"item":"½ cup white sugar"},{"item":"2 teaspoons baking powder"},{"item":"1 teaspoon baking soda"},{"item":"½ teaspoon salt"},{"item":"1 egg"},{"item":"¾ cup milk"},{"item":"⅓ cup vegetable oil"},{"item":"½ teaspoon vanilla extract"},{"item":"1 cup mashed bananas"}]',
                'instruction' => '[{"instruction_item":"Preheat the oven to 400 degrees F (205 degrees C). Line a 12-cup muffin tin with paper liners.","attached_photo":""},{"instruction_item":"Combine flour, oats, sugar, baking powder, soda, and salt in a medium bowl; set aside.","attached_photo":""},{"instruction_item":"Beat egg lightly in a large bowl. Whisk in milk, oil, and vanilla. Stir in mashed bananas. Add the flour mixture and stir until just combined. Spoon batter into the prepared muffin cups, filling each 3\/4 full.","attached_photo":""},{"instruction_item":"Bake in the preheated oven until tops spring back when lightly pressed, 18 to 20 minutes.","attached_photo":"uploads\/recipes\/user_11\/instruction\/240208_1707393522_s31K5cnOUe.jpeg"}]',
                'video_url' => '',
                'private' => rand(0,1),
                'image' => 'uploads/recipes/user_11/banner/240208_1707393522_MF63cIC6og.webp',
                'thumbnail' => 'uploads/recipes/user_11/thumbnail/240208_1707393522_NU9XDTae2Q.webp',
                'is_draft' => false
            ],
        ];

        foreach ($recipes as $recipe) {
            \App\Models\Recipe::create($recipe);
        }

        $image_library = new ImageLibrary();
        $image_library->copy_files_to_another_folder_using_put_get_function('assets/dummy_recipes','uploads/recipes');
    }
}
