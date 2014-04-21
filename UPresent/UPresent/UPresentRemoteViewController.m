//
//  UPresentRemoteViewController.m
//  UPresent
//
//  Created by Hector Curi on 4/21/14.
//  Copyright (c) 2014 Team5. All rights reserved.
//

#import "UPresentRemoteViewController.h"

@interface UPresentRemoteViewController ()
@property (strong, nonatomic) IBOutlet UILabel *title;
@property (strong, nonatomic) IBOutlet UILabel *currentSlide;

@end

@implementation UPresentRemoteViewController

@synthesize myTitle;
@synthesize title;
@synthesize currentSlide;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    self.title.text = myTitle;
}
- (IBAction)previousSlide:(id)sender {
}
- (IBAction)nextSlide:(id)sender {
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
