//
//  UPresentTableViewController.h
//  UPresent
//
//  Created by Hector Curi on 4/13/14.
//  Copyright (c) 2014 Team5. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface UPresentTableViewController : UITableViewController <UITableViewDataSource, UITableViewDelegate> {
    NSArray *exercises;
    NSMutableData *responseData;
}



@end