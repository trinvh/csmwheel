var canvasId         = "myDrawingCanvas";
var theSpeed         = 20;
var pointerAngle     = 0;
var doPrizeDetection = true;
var spinMode         = "determinedPrize";
// Custom Defined by trinvh
var wheelImageType	= "image"; // Enum('canvas','image')
var colours = {
			bgColour: [
				"#B8D430",
				"#3AB745",
				"#029990",
				"#3501CB",
				"#2E2C75",
				"#673A7E",
				"#CC0071",
				"#F80120",
				"#F35B20",
				"#FB9A00",
				"#FFCC00",
				"#FEF200"
			],
			fontColour: [
				"#333",
				"#333",
				"#333",
				"#FFF",
				"#FFF",
				"#FFF",
				"#FFF",
				"#333",
				"#333",
				"#333",
				"#333",
				"#333"
			]
		},
		width = document.getElementById(canvasId).width,
		height = document.getElementById(canvasId).height,
		halfWidth = width / 2,
		halfHeight = height / 2,

		startAngle = 0,
		arc = Math.PI / (prizes.length / 2),
		spinTimeout = null,

		isSpinning = false,

		spinArcStart = 10,
		spinTime = 0,
		spinTimeTotal = 0,

		spinVelocity = 2000,

		easeOut = function(t, b, c, d) {
			var ts = (t/=d)*t,
				tc = ts*t;
			return b+c*(tc + -3*ts + 3*t);
		},
		ctx,
		rouletteWheel = {};
// !END Custom Defined by trinvh
// --------------------------------
// VARIABLES THAT YOU DON'T NEED TO / SHOULD NOT CHANGE...
var surface;		   // Set to the drawing canvas object in the begin function.
var wheel;			   // The image of the face of the wheel is loaded in to an image object assigned to this var.
var angle 		 = 0;  // Populated with angle figured out by the threshold code in the spin function. You don't need to set this here.
var targetAngle  = 0;  // Set before spinning of the wheel begins by startSpin function depending on spinMode.
var currentAngle = 0;  // Used during the spin to keep track of current angle.
var power        = 0;  // Set when the power is selected. 1 for low, 2 for med, 3 for high.

// This is used to do ajax when using a determinedSpin mode and the value has not already been passed in via other method.
// Given that HTML canvas is not supported in IE6 or other old school browsers, we don't need to check if 
// XMLHttp request is available and fiddle around with creating activeX object etc.
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = ajaxCallback;

// This is set in the startSpin function to a random value within a range so that the last speed of the rotation of the wheel
// does not always happen at the same point before the prize the user will win. See comments in doSpin where this variable is located.
var randomLastThreshold = 150;

// Pointer to the setTimout for the call to the doSpin function. Is global var so can clear the timeout if reset is clicked before wheel has stopped spinning.
var spinTimer;

// Used to track status of the wheel, set to 'spinning' when the wheel is spinning.
// Only used in this code to stop the spin button working again while the wheel is currently spinning, you could use in your project for additional things.
// Note: spin button will only work again after wheel has been reset.
var wheelState = 'reset';

var can_wheel = 0;
var remain_wheel = 0;

function begin() 
{
	// Get our Canvas element
	surface = document.getElementById(canvasId);

	// If canvas is supported then load the image.
	if (surface.getContext) 
	{
		wheel = new Image();
		wheel.onload = initialDraw;
		if(wheelImageType === 'image') {
			wheel.src = wheelImageName;
		} else {
			var canvas = document.getElementById(canvasId),
				outsideRadius = halfWidth,
				textRadius = 194,
				insideRadius = 100,
				angle,
				text;

			if (!canvas.getContext) {
				return;
			}
			
			ctx = canvas.getContext("2d");
			ctx.clearRect(0,0,width,height);
			
			ctx.strokeStyle = "black";
			ctx.font = "12px Helvetica, Arial";
			
			arc = Math.PI / (prizes.length / 2);

			//Draw circle
			prizes.forEach(function(restaurant, i) {
				angle = startAngle + i * arc;
				ctx.fillStyle = colours.bgColour[i];
				
				ctx.beginPath();
				ctx.arc(halfWidth, halfHeight, outsideRadius, angle, angle + arc, false);
				ctx.arc(halfWidth, halfHeight, insideRadius, angle + arc, angle, true);
				ctx.fill();
				
				ctx.save();

				//Render text
				ctx.fillStyle = colours.fontColour[i];
				ctx.translate(halfWidth + Math.cos(angle + arc / 2) * textRadius, 
							halfHeight + Math.sin(angle + arc / 2) * textRadius);
				ctx.rotate(angle + arc / 2 + Math.PI / 2);
				text = restaurant.name;
				//ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
				printAt(ctx, text, -ctx.measureText(text).width / 2, 0, 14, ((2 * Math.PI * textRadius) / prizes.length) - 10);
				ctx.restore();
			});
			
			//Arrow
			ctx.fillStyle = "#333";
			ctx.beginPath();
			ctx.moveTo(halfWidth - 4, halfHeight - (outsideRadius + 25));
			ctx.lineTo(halfWidth + 4, halfHeight - (outsideRadius + 25));
			ctx.lineTo(halfWidth + 4, halfHeight - (outsideRadius + 15));
			ctx.lineTo(halfWidth + 9, halfHeight - (outsideRadius + 15));
			ctx.lineTo(halfWidth + 0, halfHeight - (outsideRadius - 0));
			ctx.lineTo(halfWidth - 9, halfHeight - (outsideRadius + 15));
			ctx.lineTo(halfWidth - 4, halfHeight - (outsideRadius + 15));
			ctx.lineTo(halfWidth - 4, halfHeight - (outsideRadius + 25));
			ctx.fill();
			wheel.src = canvas.toDataURL();
		}
	}
}

function printAt(context, text, x, y, lineHeight, fitWidth) {
	fitWidth = fitWidth || 0;
	
	if (fitWidth <= 0) {
		context.fillText( text, x, y );
		return;
	}
	
	var str, splitDash, headText, tailText, idx;

	for (idx = 1; idx <= text.length; idx++) {
		str = text.substr(0, idx);
		
		if (context.measureText(str).width > fitWidth) {
			splitDash = (text.charAt(idx-2) != " ") ? "-" : "";
			headText = text.substr(0, idx-1) + splitDash;
			tailText = text.substr(idx-1);
			context.fillText( headText, -context.measureText(headText).width / 2, y - lineHeight);
			rouletteWheel.printAt(context, tailText, -context.measureText(tailText).width / 2, y + lineHeight, lineHeight,  fitWidth - 10);
			return;
		}
	}
	
	context.fillText(text, x, (y ? y - lineHeight : y));
};

// ==================================================================================================================================================
// This function draws the wheel on the canvas in its intial position. Without it only the background would be displayed.
// ==================================================================================================================================================
function initialDraw(e)
{
	var surfaceContext = surface.getContext('2d');
	surfaceContext.drawImage(wheel, 0, 0);
}

// ==================================================================================================================================================
// This function is called when the spin button is clicked, it works out the targetAngle using the specified spin mode, then kicks off the spinning.
// ==================================================================================================================================================
function startSpin(determinedValue)
{
	if(can_wheel <= 0) {
		displayPopup('Tài khoản không có lượt quay', '<div class="alert alert-danger">Tài khoản của bạn không có lượt quay nào. Vui lòng nạp thêm tiền để có thể quay tiếp.<br>Chúc bạn may mắn !</div');
		return;
	}
	var stopAngle = undefined;	

	if (spinMode == "random")
	{
		stopAngle = Math.floor(Math.random() * 360);
	}
	else if (spinMode == "determinedAngle")
	{
		if (typeof(determinedValue) === 'undefined')
		{
			if (determinedGetUrl)
			{
				xhr.open('GET', determinedGetUrl, true);
				xhr.send('');
			}
		}
		else
		{
			stopAngle = determinedValue;
		}
	}
	else if (spinMode == "determinedPrize")
	{	
		if (typeof(determinedValue) === 'undefined')
		{
			if (determinedGetUrl)
			{
				xhr.open('GET', determinedGetUrl, true);
				xhr.send('');
			}
		}
		else
		{
			stopAngle = Math.floor(prizes[determinedValue]['startAngle'] + (Math.random() * (prizes[determinedValue]['endAngle'] - prizes[determinedValue]['startAngle'])));
		}
	}

	if ((typeof(stopAngle) !== 'undefined') && (wheelState == 'reset') && (power))
	{
		stopAngle = (360 + pointerAngle) - stopAngle;
		targetAngle = (360 * (power * 6) + stopAngle);
		randomLastThreshold = Math.floor(90 + (Math.random() * 90));

		wheelState = 'spinning';
		doSpin();
	}
}

is_win = false;
$('#popupMessage').on('hidden.bs.modal', function (e) {
	resetWheel();
	$('#spin_button').prop('disabled', false);
	$('#spin_button b').removeClass('rotateOut').removeClass('animated').removeClass('forever');
	$('#confetti-world').hide();
});
// ==================================================================================================================================================
// This function is used when doing a XMLHttpRequest to check the ready state and if got response then process it.
// ==================================================================================================================================================
function ajaxCallback()
{
	if(xhr.readyState == 4) {
		if(xhr.status == 200) {
			var resp = JSON.parse(xhr.responseText);
			$('#user_can_wheel').text(resp.remain_wheel);
			can_wheel = resp.can_wheel;
			remain_wheel = resp.remain_wheel;
			if(resp.can_wheel <= 0) {
				displayPopup('Tài khoản không có lượt quay', '<div class="alert alert-danger">Tài khoản của bạn không có lượt quay nào. Vui lòng nạp thêm tiền để có thể quay tiếp.<br>Chúc bạn may mắn !</div');
			} else {
				is_win = resp.win;
				startSpin(resp.prize);
			}
		} else {
			displayPopup('Không kết nối được server', '<div class="alert alert-danger">Không kết nối được server.<br>Vui lòng nhấn F5 hoặc refresh trang để thử lại !</div');
		}
	} 
}

function displayPopup(title, body) {
	$('#popupMessage').find('.modal-title').text(title);
	$('#popupMessage').find('.modal-body').html(body);
	$('#popupMessage').modal(true);
}

// ==================================================================================================================================================
// This function actually rotates the image making it appear to spin, a timer calls it repeatedly to do the animation.
// The wheel rotates until the currentAngle meets the targetAngle, slowing down at certain thresholds to give a nice effect.
// ==================================================================================================================================================
function doSpin() 
{	
	// Grab the context of the canvas.
	var surfaceContext = surface.getContext('2d');

	// Save the current context - we need this so we can restore it later.
	surfaceContext.save();
	
	// Translate to the center point of our image.
	surfaceContext.translate(wheel.width * 0.5, wheel.height * 0.5);
	
	// Perform the rotation by the angle specified in the global variable (will be 0 the first time).
	surfaceContext.rotate(DegToRad(currentAngle));
	
	// Translate back to the top left of our image.
	surfaceContext.translate(-wheel.width * 0.5, -wheel.height * 0.5);
	
	// Finally we draw the rotated image on the canvas.
	surfaceContext.drawImage(wheel, 0, 0);
	
	// And restore the context ready for the next loop.
	surfaceContext.restore();

	// ------------------------------------------
	// Add angle worked out below by thresholds to the current angle as we increment the currentAngle up until the targetAngle is met.
	currentAngle += angle;
	
	// ------------------------------------------
	// If the currentAngle is less than targetAngle then we need to rotate some more, so figure out what the angle the wheel is to be rotated 
	// by next time this function is called, then set timer to call this function again in a few milliseconds.
	if (currentAngle < targetAngle)
	{
		// We can control how fast the wheel spins by setting how much is it to be rotated by each time this function is called.
		// In order to do a slowdown effect, we start with a high value when the currentAngle is further away from the target
		// and as it is with certian thresholds / ranges of the targetAngle reduce the angle rotated by - hence the slowdown effect.
		
		// The 360 * (power * 6) in the startSpin function will give the following...
		// HIGH power = 360 * (3 * 6) which is 6480
		// MED power = 360 * (2 * 6) which equals 4320
		// LOW power = 360 * (1 * 6) equals 2160.
		
		// Work out how much is remaining between the current angle and the target angle.
		var angleRemaining = (targetAngle - currentAngle);
		
		// Now use the angle remaining to set the angle rotated by each loop, reducing the amount of angle rotated by as
		// as the currentAngle gets closer to the targetangle.
		if (angleRemaining > 6480)
			angle = 55;
		else if (angleRemaining > 5000)		// NOTE: you can adjust as desired to alter the slowdown, making the stopping more gradual or more sudden.
			angle = 45;						// If you alter the forumla used to work out the targetAngle you may need to alter these.
		else if (angleRemaining > 4000)
			angle = 30;
		else if (angleRemaining > 2500)
			angle = 25;
		else if (angleRemaining > 1800)
			angle = 15;
		else if (angleRemaining > 900)
			angle = 11.25;
		else if (angleRemaining > 400)
			angle = 7.5;
		else if (angleRemaining > 220)					// You might want to randomize the lower threhold numbers here to be between a range
			angle = 3.80;								// otherwise if always within last 150 when the speed is set to 1 degree the user can
		else if (angleRemaining > randomLastThreshold)	// tell what prize they will win before the wheel stops after playing the wheel a few times.
			angle = 1.90;								// This variable is set in the startSpin function. Up to you if you want to randomise the others.
		else
			angle = 1;		// Last angle should be 1 so no risk of the wheel overshooting target if using preDetermined spin mode 
							// (only a problem if pre-Determined location is near edge of a segment).
		
		// Set timer to call this function again using the miliseconds defined in the speed global variable.
		// This effectivley gets creates the animation / game loop.
		
		// IMPORTANT NOTE: 
		// Since creating this wheel some time ago I have learned than in order to do javascript animation which is not affected by the speed at which 
		// a device can exectute javascript, a "frames per second" approach with the javscript function requestAnimationFrame() should be used. 
		// I have not had time to learn about and impliment it here, so you might want to look in to it if this method of animation is not 
		// smooth enough for you.
		spinTimer = setTimeout("doSpin()", theSpeed);
	}
	else
	{
		// currentAngle must be the same as the targetAngle so we have reached the end of the spinning.
		
		// Update this to indicate the wheel has finished spinning.
		// Not really used for anything in this example code, but you might find keeping track of the wheel state in a game you create
		// is handy as you can check the state and do different things depending on it (reset, spinning, won, lost etc).
		wheelState = 'stopped';
		
		// If to do prize dection then work out the prize pointed to.
		if ((doPrizeDetection) && (prizes))
		{
			// Get how many times the wheel has rotated past 360 degrees.
			var times360 = Math.floor(currentAngle / 360);
			
			// From this compute the angle of where the wheel has stopped - this is the angle of where the line between 
			// segment 8 and segment 1 is because this is the 360 degree / 0 degree (12 o'clock) boundary when then wheel first loads.
			var rawAngle = (currentAngle - (360 * times360));
			
			// The value above is still not quite what we need to work out the prize.
			// The angle relative to the location of the pointer needs to be figured out.
			var relativeAngle =  Math.floor(pointerAngle - rawAngle);
			
			if (relativeAngle < 0)
				relativeAngle = 360 - Math.abs(relativeAngle);
					
			// Now we can work out the prize won by seeing what prize segment startAngle and endAngle the relativeAngle is between.
			for (x = 0; x < (prizes.length); x ++)
			{
				if ((relativeAngle >= prizes[x]['startAngle']) && (relativeAngle <= prizes[x]['endAngle']))
				{
					// Do something with the knowlege. For this example the user is just alerted, but you could play a sound,
					// change the innerHTML of a div to indicate the prize etc - up to you.
					if(is_win) {
						$('#confetti-world').show();
						displayPopup('Chúc mừng bạn !', '<div class="alert alert-success">Chúc mừng bạn đã trúng giải thưởng <strong>' + prizes[x]['name'] + 'đ</strong><br>Tiền sẽ được cộng vào tài khoản, vui lòng logout/in để thấy ^^</div');
						break;
					} else {
						displayPopup('Xin chia buồn...', '<div class="alert alert-warning">Rất tiếc bạn không trúng giải nào cả.<br>Chúc bạn may mắn lần sau !</div');
						break;
					}
					
				}
			}
		}
		
		// ADD YOUR OWN CODE HERE.
		// If no prize detection then up to you to do whatever you want when the spinning has stopped.
	}
}

// ==================================================================================================================================================
// Quick little function that converts the degrees to radians.
// ==================================================================================================================================================
function DegToRad(d) 
{
	return d * 0.0174532925199432957;
}

// ==================================================================================================================================================
// This function sets the class name of the power TDs to indicate what power has been selected, and also sets power variable used by startSpin code.
// It is called by the onClick of the power table cells on the page. 
// ==================================================================================================================================================
function powerSelected(powerLevel)
{
	// In order to stop the change of power duing the spinning, only do this if the wheel is in a reset state.
	if (wheelState == 'reset')
	{
		power = powerLevel;
	}
}

// ==================================================================================================================================================
// This function re-sets all vars as re-draws the wheel at the original position. Also re-sets the power and spin buttons on the example wheel.
// ==================================================================================================================================================
function resetWheel()
{
	// Ensure that if wheel is spining then it is stopped.
	clearTimeout(spinTimer);
	
	// Re-set all vars to do with spinning angles.
	angle 		 = 0;
	targetAngle  = 0;
	currentAngle = 0;

	// Set back to reset so that power selection and click of Spin button work again.
	wheelState = 'reset';
	
	// Call function to draw wheel in start-up poistion.
	initialDraw();
	is_win = false;
}