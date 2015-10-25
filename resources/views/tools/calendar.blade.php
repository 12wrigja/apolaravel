@extends('templates.crud_template')

@section('crud_form')
    <h2>The APO Theta Upsilon Google Calendar</h2>
    <p>You can use this calendar to view all the upcoming events pertaining to APO. You can also use the "Add to Google Calendar" button (located in the bottom left) to add this calendar to your personal calendar.</p>
    <iframe src="https://calendar.google.com/calendar/embed?showPrint=0&amp;height=768&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=calendar%40apo.case.edu&amp;color=%23875509&amp;ctz=America%2FNew_York" style="border:solid 1px #777" width="1024" height="768" frameborder="0" scrolling="no"></iframe>

@endsection

