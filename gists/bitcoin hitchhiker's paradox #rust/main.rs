extern crate chrono;
use std::fs::File;
use std::io::{self, prelude::*, BufReader};
use chrono::prelude::*;
use rand::Rng;
use std::collections::HashMap;

fn main() -> io::Result<()> {      
    let min_date = "0";
    let mode_date = "0";
    let iterations = 50000;
    let filename = "time.txt";

    if mode_date != "0" {
        println!("Considering only blocks on date {}...", mode_date);
    }
    if min_date != "0" {
        println!("Considering only blocks since date {}...", min_date);
    }

    let mut last_time = 0;
    let mut sum = 0;
    let mut count = 0;
    let mut lowest = 999999999999999999;
    let mut highest = -1;

    let file = File::open(filename)?;
    let reader = BufReader::new(file);
    for line in reader.lines() {
        let str = line?;
        let split = str.split(",");
        let vec = split.collect::<Vec<&str>>();
        let height = vec[0];
        if height == "id" { continue; }
        if height == "0" { continue; } // also ignore genesis (because it is prior to the other blocks)
        let date = NaiveDateTime::parse_from_str(vec[1], "%Y-%m-%d %H:%M:%S");
        let time = date.unwrap().timestamp();
        if mode_date != "0" { if date.unwrap().format("%Y-%m-%d").to_string() != mode_date { continue; } }
        if min_date != "0" { if time < NaiveDateTime::parse_from_str(&[min_date.to_string(),"00:00:00".to_string()].join(" "), "%Y-%m-%d %H:%M:%S").unwrap().timestamp() { continue; } }
        if lowest > time {
            lowest = time;
        }
        if highest < time {
            highest = time;
        }      
        if last_time != 0 {
            sum = sum + ( time - last_time );
            count += 1;
        }
        last_time = time;
    }

    if count > 0 {
        let sec = sum as f32 / count as f32;
        let min = sec / 60 as f32;
        println!("Average block time: {} minutes.", min);
    }

    let mut arr: Vec<HashMap<String, i64>> = Vec::new();
    for _iterations_value in 0..iterations {
        let mut arr_this = HashMap::new();
        let mut rng = rand::thread_rng();
        let rand = rng.gen_range(lowest..highest);
        arr_this.insert("rand".to_string(), rand);
        arr_this.insert("diff".to_string(), 9999999999999);
        arr.push(arr_this);
    }

    let file = File::open(filename)?;
    let reader = BufReader::new(file);
    for line in reader.lines() {
        let str = line?;
        let split = str.split(",");
        let vec = split.collect::<Vec<&str>>();
        let height = vec[0];
        if height == "id" { continue; }
        if height == "0" { continue; } 
        let date = NaiveDateTime::parse_from_str(vec[1], "%Y-%m-%d %H:%M:%S");
        let time = date.unwrap().timestamp();
        if mode_date != "0" { if date.unwrap().format("%Y-%m-%d").to_string() != mode_date { continue; } }
        if min_date != "0" { if time < NaiveDateTime::parse_from_str(&[min_date.to_string(),"00:00:00".to_string()].join(" "), "%Y-%m-%d %H:%M:%S").unwrap().timestamp() { continue; } }
        for iterations_value in 0..iterations {
            let diff_this = time - arr[iterations_value]["rand"];
            if diff_this >= 0 && diff_this < arr[iterations_value]["diff"] {
                *arr[iterations_value].get_mut("diff").unwrap() = diff_this;
            }
        }
    }

    let mut waiting_sum = 0;
    let mut waiting_count = 0;
    for iterations_value in 0..iterations {
        waiting_sum += arr[iterations_value]["diff"];
        waiting_count += 1;
    }
    let waiting_result = waiting_sum as f32 / (waiting_count as f32 * 60 as f32);
    println!("Averaged waiting time for next block on random start times ({} iterations): {} minutes.", iterations, waiting_result);

    Ok(())
}
