<?php

namespace Modules\Admission\Http\Listeners;


use Modules\Admission\Repositories\Interfaces\AdmissionInterface;
use Modules\Admission\Repositories\Interfaces\AdmissionMarkInterface;

class AdmissionMarkListener
{
    /**
     * @var AdmissionInterface
     */
    protected $admissionRepository;
    /**
     * @var AdmissionMarkInterface
     */
    protected $admissionMarkRepository;
    /**
     * RenderingSiteMapListener constructor.
     * @param AdmissionMarkInterface $admissionMarkRepository
     */
    public function __construct(
        AdmissionInterface $admissionRepository,
        AdmissionMarkInterface $admissionMarkRepository
    ) {
        $this->admissionRepository = $admissionRepository;
        $this->admissionMarkRepository = $admissionMarkRepository;
    }

    public function handle($event): void
    {
        $data = $event->data;
        $mark = $event->mark;

//        dd($mark[1]);
//        $id = $data->admissions_id;
//        dd($mark);
        foreach ($mark as $key => $innerArray) {
            $mark_array['id'] = $key;
            $admission = $this->admissionMarkRepository->advancedGet([
                'condition' => ['admissions_id' => $key],
//            'take'      => 1,
            ]);
//            dd($key);
            $mark_number = $this->averageMark($admission);
//        dd($mark_number);
            $this->admissionRepository->createOrUpdate([
                'mark' => $mark_number,
            ], $mark_array);
        }
//        dd($data);
    }

    protected function averageMark($admission)
    {
//        $totalMarks = $this->marks->sum('mark');
//        $numberOfMarks = $this->marks->count();
        $average = array();
        foreach ($admission as $value){
            $total_mark = $value->subject->total_mark;
            $mark = $value->mark;
            $average[] = ($mark * 100) / $total_mark;
        }
        $totalMarks = array_sum($average);
        $numberOfMarks = count($average);

//        dd($numberOfMarks);
        return $numberOfMarks > 0 ? ($totalMarks / $numberOfMarks) : 0;
    }
}
