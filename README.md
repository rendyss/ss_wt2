# ss_wt2

Super simple WordPressi to display team member using shortcode

## Display multiple team members
`[ss_teammember]`

## Dispplay single team member by its ID
`[ss_teammember id=1]`
Change the number with a specified team member id

## Parameters
for multiple team member, you can limit by using `limit` parameter.
`[ss_teammember limit=2]` will display first two team members and ordered by its name

And also there are some other parameters
<ul>
<li>`name` to include team member's name into layout, default is TRUE</li>
<li>`position` to include team member's position into layout, default is TRUE</li>
<li>`email` to include team member's email into layout, default is TRUE</li>
<li>`website` to include team member's website into layout, default is TRUE</li>
<li>`image` to include team member's image into layout, default is TRUE</li>
</ul>
